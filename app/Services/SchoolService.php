<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\School;
use Exception;

class SchoolService

{
    private const SCHOOL_LIST_API_URLS = [
        'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=6%2C7%2C9%2C43&search=true&json=true&page=',
        'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=30%2C52&search=true&json=true&page=',
        'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=14%2C15%2C58%2C59&search=true&json=true&page=',
        'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=40%2C47&search=true&json=true&page=',
    ];

    private const SINGLE_SCHOOL_API_URL = 'https://www.viis.gov.lv/registri/iestades/';

    private const COORDINATE_API = 'http://api.positionstack.com/v1/forward';
    private const COORDINATE_API_KEY = '3c165f47095e39427c0bed9151e09d9f';

    /**
     * @throws \JsonException
     */
    private function getAllSchoolData(string $url, string $page)
    {
        try {
            $xmlString = file_get_contents($url . $page);
            return json_decode($xmlString, true, 512, JSON_THROW_ON_ERROR)['data']['_rows']['hits'];
        } catch (Exception $e) {
            //do nothing
        }
    }

    /**
     * @throws \JsonException
     */
    private function getSpecificSchoolData(string $id)
    {
        try {
            $xmlString = file_get_contents(self::SINGLE_SCHOOL_API_URL . $id);
            return json_decode($xmlString, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            //do nothing
        }

    }

    /**
     * @throws \JsonException
     */
    private function getCoordinates(string $address)
    {
        $queryString = http_build_query([
            'access_key' => self::COORDINATE_API_KEY,
            'query' => $address,
            'region' => 'Latvia',
            'output' => 'json',
            'limit' => 1,
        ]);

        $ch = curl_init(sprintf('%s?%s', self::COORDINATE_API, $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        $apiResult = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return $apiResult['data'][0]['latitude'] . ',' . $apiResult['data'][0]['longitude'];
    }

    public function execute()
    {
        $school_ids = [];
        foreach (self::SCHOOL_LIST_API_URLS as $school_list_url) {
            $page = 1;
            while ($page !== null) {
                $data = $this->getAllSchoolData($school_list_url, $page);
                if (empty($data)) {
                    $page = null;
                } else {
                    foreach ($data as $school_data) {
                        $school_ids[] = $school_data['_id'];
                    }
                    $page++;
                }
            }
        }

        foreach ($school_ids as $id) {
            if (!isset($this->getSpecificSchoolData($id)['data']) || empty($this->getSpecificSchoolData($id)['data']['pamatdati'])) {
                continue;
            }
            try {
                $all_data = $this->getSpecificSchoolData($id)['data'];
            } catch (Exception $e) {
                continue;
            }

            $data = $all_data['pamatdati'][0];
            $info_data = $all_data['pamatinfo'][0];
            $coordinates = '';
            try {
                $coordinates = $this->getCoordinates($data['AddressText']);
            } catch (Exception $e) {
                $coordinates = 'null';
            }
            $school = School::where('school_data_id', $id)->first();

            if ($school === null) {
                $school = new School();
            }

            $school->school_title = $data['InstitutionName'];
            $school->address = $data['AddressText'];
            $school->type = $data['InstitutionTypeId'];
            $school->type_name = $data['InstitutionType'];
            $school->school_data_id = $id;
            $school->coordinates = $coordinates;
            $school->registration_number = $data['InstitutionRegistrationNumber'] ?? '0987654321';
            $school->phone_number = $data['Phone'] ?? '0987654321';
            $school->email = $data['EMail'] ?? 'test@test.lv';
            $school->url = $data['HomePageUrl'] ?? 'https://google.lv';
            $school->image = 'https://www.sigulda.lv/upload/Image/eekas_iestaades/Maijas%20Pilagas%20Ledurgas%20makslas%20skola.jpg';
            $school->manager = $info_data['Manager'] ?? 'test manager';
            $school->save();
            $this->addCriteria($school, $all_data);
        }
    }

    private function addCriteria($school, $data) {
        $programms = $data['programmas'];
        $extraCurriculars = $data['programmas_interesu'];
        foreach ($programms as $programm) {
            $criteria = Criteria::where('code', $programm['EducationProgramCode'])->first();
            if ($criteria === null) {
                $criteria = new Criteria();
            }
            $criteria->code = $programm['EducationProgramCode'] ?? '-';
            $criteria->name = $programm['EducationProgramGroupName'] ?? '-';
            $criteria->overname = $programm['EducationProgramScopeName'] ?? '-';
            $criteria->type = "Izglības programma";
            $criteria->image = 'https://images.pexels.com/photos/945471/pexels-photo-945471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2';
            $criteria->save();
            $criteria->school()->attach([$school->id]);
            print_r($criteria->code);
        }
        foreach ($extraCurriculars as $extraCurricular) {
            $criteria = Criteria::where('code', $extraCurricular['Code'])->first();
            if ($criteria === null) {
                $criteria = new Criteria();
            }
            $criteria->code = $extraCurricular['Code'] ?? '-';
            $criteria->name = $extraCurricular['Name'] ?? '-';
            $criteria->image = 'https://images.pexels.com/photos/945471/pexels-photo-945471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2';
            $criteria->overname = $extraCurricular['GroupOrCollectiveName'] ?? '-';
            $criteria->type = "Papildus interešu programma";
            $criteria->save();
            $criteria->school()->attach([$school->id]);
            print_r($criteria->code);
        }
    }
}
