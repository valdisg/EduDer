<?php

namespace App\Services;

use App\Models\School;

class SchoolService

{
    private $specificSchoolUrl = 'https://www.viis.gov.lv/registri/iestades/';

    private $allSchoolUrl = 'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=6%2C7%2C9%2C43&search=true&json=true&page=';
    private $coordinateAPI = 'http://api.positionstack.com/v1/forward';
    private $coordinateAPIKey = '3c165f47095e39427c0bed9151e09d9f';

    private function getAllSchoolData(string $page){
        $xmlString = file_get_contents($this->allSchoolUrl . $page);
        return json_decode($xmlString, true);
    }

    private function getSpecificSchoolData(string $id) {
        $xmlString = file_get_contents($this->specificSchoolUrl . $id);
        $data = json_decode($xmlString, true);
        return $data["data"]["pamatdati"][0];
    }

    private function getCoordinates(string $address) {
        $queryString = http_build_query([
            'access_key' => $this->coordinateAPIKey,
            'query' => $address,
            'region' => 'Latvia',
            'output' => 'json',
            'limit' => 1,
        ]);

        $ch = curl_init(sprintf('%s?%s', $this->coordinateAPI, $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        $apiResult = json_decode($json, true);
        $coordinates = $apiResult['data'][0]['latitude'] . ',' . $apiResult['data'][0]['longitude'];
        return $coordinates;
    }

    public function execute()
    {
        $page = 1;
        while ($page < 2) {
            $data = $this->getAllSchoolData($page);
            foreach ($data['data']['_rows']['hits'] as &$row) {
                $schoolId = $row['_source']['Id'];
                $schoolData = $this->getSpecificSchoolData($schoolId);
                $address = $schoolData['AddressText'];
                $coordinates = $this->getCoordinates($address);
//                School::updateOrCreate(['school_title' => $schoolData['InstitutionName']],[
//                    'school_title' => $schoolData['InstitutionName'],
//                    'address' => $address,
//                    'coordinates' => $coordinates
//                ]);
            }
            $page += 1;
        }
        return 'Update done';
    }
}
