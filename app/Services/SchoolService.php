<?php

namespace App\Services;

use App\Models\School;

class SchoolService

{
    private $specificSchoolUrl = 'https://www.viis.gov.lv/registri/iestades/';
    private $allSchoolUrl = 'https://www.viis.gov.lv/registri/iestades?InstitutionTypeId=6%2C7%2C9%2C43&search=true&json=true&page=1';

    private function getAllSchoolData(){
        $xmlString = file_get_contents($this->allSchoolUrl);
        return json_decode($xmlString, true);
    }

    private function getSpecificSchoolData(string $id) {
        $xmlString = file_get_contents($this->specificSchoolUrl . $id);
        $data = json_decode($xmlString, true);
        return $data["data"]["pamatdati"];
    }

    private function getSchoolId($data){
        return $data['data']['_rows']['hits'][0]['_source']['Id'];
    }
    public function execute()
    {
        $data = $this->getAllSchoolData();
        $schoolId = $this->getSchoolId($data);
        $schoolData = $this->getSpecificSchoolData($schoolId);
        School::create([
            'school_title' => $schoolData[0]['InstitutionName'],
            'address' => $schoolData[0]['AddressText']
        ]);
        return $schoolData[0];
    }
}
