<?php

namespace App\Services;

use App\Models\School;

class SchoolService

{
    private $specificSchoolUrl = 'https://www.viis.gov.lv/registri/iestades/';
    private $allSchoolUrl = 'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=6%2C7%2C9%2C43&search=true&json=true&page=';

    private function getAllSchoolData(string $page){
        $xmlString = file_get_contents($this->allSchoolUrl . $page);
        return json_decode($xmlString, true);
    }

    private function getSpecificSchoolData(string $id) {
        $xmlString = file_get_contents($this->specificSchoolUrl . $id);
        $data = json_decode($xmlString, true);
        return $data["data"]["pamatdati"][0];
    }

    private function getSchoolId($data){
        return $data['data']['_rows']['hits'][0]['_source']['Id'];
    }
    public function execute()
    {
        $page = 1;
        while ($page < 10) {
            $data = $this->getAllSchoolData($page);
            foreach ($data['data']['_rows']['hits'] as &$row) {
                $schoolId = $row['_source']['Id'];
                $schoolData = $this->getSpecificSchoolData($schoolId);
                School::updateOrCreate(['school_title' => $schoolData['InstitutionName']],[
                    'school_title' => $schoolData['InstitutionName'],
                    'address' => $schoolData['AddressText']
                ]);
            }
            $page += 1;
        }
        return 'Yaaaaay!!!';
    }
}
