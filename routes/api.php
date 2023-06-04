<?php

use App\Http\Resources\SchoolCollection;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/schools', function (Request $request) {
    return response()->json(json_decode(json_encode(new SchoolCollection(School::all()))),200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
});



Route::get('/', function (Request $request) {
    return response()->json(json_decode('{
  "schools": [
    {
      "schoolData":
      {
        "id": "1",
        "schoolName": "Rīgas Valsts 1. ģimnāzija",
        "imageUrl": "https://lh5.googleusercontent.com/p/AF1QipOWcoOi_cHuQamKbAGTGAqoM4kI1_NRI32hfI9D=w408-h544-k-no",
        "schoolUrl": "http://r1g.edu.lv/v/index/",
        "address": "Raiņa bulvāris 8, Rīga, LV-1008",
        "coordinates": "56.952479, 24.112738",
        "tips": "Ģimnāzija"
      },
      "matchingCriteria":
      [
        "4"
      ]
    },
    {
      "schoolData":
      {
        "id": "2",
        "schoolName": "Rīgas Valsts 2. ģimnāzija",
        "imageUrl": "https://img.abc.lv/articles/open/o/l/media/oldabcms/oldabcms_42773.jpg_oldabcms_42773_600x400.jpg",
        "schoolUrl": "https://rv2g.edu.lv/index.php/lv/",
        "address": "Krišjāņa Valdemāra iela 1, Centra rajons, Rīga, LV-1010",
        "coordinates": "56.953974, 24.106470",
        "tips": "Ģimnāzija"
      },
      "matchingCriteria":
      [
        "2", "3"
      ]
    }
  ],
  "criteria": [
    {
      "id": "1",
      "title": "Sports",
      "imageUrl": "https://images.pexels.com/photos/1192027/pexels-photo-1192027.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2",
      "nestedCriteria": [
        {
          "id": "2",
          "title": "Basketbols",
          "imageUrl": "https://images.pexels.com/photos/945471/pexels-photo-945471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
        },
        {
          "id": "3",
          "title": "Hokejs",
          "imageUrl": "https://images.pexels.com/photos/33286/ice-hockey-puck-players-game.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
        }
      ]
    },
    {
      "id": "4",
      "title": "Dejas",
      "imageUrl": "https://images.pexels.com/photos/175658/pexels-photo-175658.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
    },
    {
      "id": "100",
      "title": "Lauksaimniecība",
      "childCriteria": ["100", "200", "300", "400"],
      "imageUrl": "https://image.slidesharecdn.com/msuzaajaizemtei110319-1-110319090107-phpapp02/85/iespja-pelnt-lauksaimniecb-lopkopb-un-enertik-4-320.jpg?cb=1672886285"
    }
  ]
}'),200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
});
