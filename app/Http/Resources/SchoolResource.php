<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CriteriaCollection;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'schoolData' =>
                    [
                        'id' => $this->id,
                        'schoolName' => $this->school_title,
                        'address' => $this->address,
                        'coordinates' => $this->coordinates,
                        'imageUrl' => $this->image,
                    ],
                'matchingCriteria'=> $this->criteria
            ];
    }
}
