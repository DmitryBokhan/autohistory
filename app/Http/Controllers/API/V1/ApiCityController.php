<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCityController extends Controller
{


    /**
     * Получить список всех стран
     * @return \Illuminate\Support\Collection
     */
    public function countries()
    {
        return DB::table('countries')->get();
    }

    /**
     * Получить список всех регионов в стране
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function regions(Request $request)
    {
        return DB::table('regions')
            ->leftJoin('countries', 'regions.country_id', '=', 'countries.id')
            ->select('regions.id', 'regions.name' )
            ->where('countries.name', $request->country)->get();
    }

    /**
     * Получить список всех городов в регионе
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function cities(Request $request)
    {
        return DB::table('cities')
            ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->leftJoin('regions', 'cities.region_id', '=', 'regions.id')
            ->select('cities.id', 'cities.name' )
            ->where('countries.name', $request->country)
            ->where('regions.name', $request->region)->get();
    }

    /**
     * Получить id города
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getCityId(Request $request)
    {
        return DB::table('cities')
            ->join('regions', 'cities.region_id', '=', 'regions.id')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->select('cities.id')
            ->where('countries.name', $request->country)
            ->where('regions.name', $request->region)
            ->where('cities.name', $request->city)
            ->get();
    }
}
