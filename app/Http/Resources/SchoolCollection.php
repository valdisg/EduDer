<?php

namespace App\Http\Resources;

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
        return [
            'schools' => $this->collection,
            'criteria' => [
                [
                    [
                        "id" => "1",
                        "title" => "Sports",
                        "imageUrl" => "https://images.pexels.com/photos/1192027/pexels-photo-1192027.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2",
                        "nestedCriteria" => [
                            [
                                "id" => "2",
                                "title" => "Basketbols",
                                "imageUrl" => "https://images.pexels.com/photos/945471/pexels-photo-945471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                            ],
                            [
                                "id" => "3",
                                "title" => "Hokejs",
                                "imageUrl" => "https://images.pexels.com/photos/33286/ice-hockey-puck-players-game.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                            ]
                        ]
                    ],
                    [
                        "id" => "4",
                        "title" => "Dejas",
                        "imageUrl" => "https://images.pexels.com/photos/175658/pexels-photo-175658.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                    ],
                    [
                        "id" => "100",
                        "title" => "Lauksaimniecība",
                        "childCriteria" => [
                            "100",
                            "200",
                            "300",
                            "400"
                        ],
                        "imageUrl" => "https://image.slidesharecdn.com/msuzaajaizemtei110319-1-110319090107-phpapp02/85/iespja-pelnt-lauksaimniecb-lopkopb-un-enertik-4-320.jpg?cb=1672886285"
                    ]
                ]
            ],
        ];
    }
}
