<?php

namespace App\Http\Resources;

use App\Models\Criteria;
use App\Http\Resources\CriteriaCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $criteria = new CriteriaCollection(Criteria::has('children')->get());
        return [
            'schools' => $this->collection,
            'criteria' => $criteria->collection
        ];
    }
}
