<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCarsBaseController extends Controller
{

    /**
     * Класс для связанного выбора модели в позиции.
     * AJAX запросом получаем дынные для каждого поля (выбор модели)
     */

    /**
     * Получить марки автомобилей
     * @return \Illuminate\Support\Collection
     */
    public function marks()
    {
        return DB::table('carsbase')->distinct()->pluck('mark');
    }

    /**
     * Получить все модели определенной марки
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function models(Request $request)
    {
        return DB::table('carsbase')->distinct()
            ->where('mark', $request->mark)
            ->pluck('model');
    }

    /**
     * Получить типы двигателей определенной модели
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function engines(Request $request)
    {
        return DB::table('carsbase')->distinct()
            ->where('mark', $request->mark)
            ->where('model', $request->model)
            ->pluck('engine-type');
    }

    /**
     * Получить объемы двигателей определенной модели
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function volumes(Request $request)
    {
        return DB::table('carsbase')->distinct()
            ->where('mark', $request->mark)
            ->where('model', $request->model)
            ->where('engine-type', $request->engine)
            ->pluck('volume');
    }

    /**
     * Получить типы трансмиссий определенной модели
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function transmissions(Request $request)
    {
        return DB::table('carsbase')->distinct()
            ->where('mark', $request->mark)
            ->where('model', $request->model)
            ->where('engine-type', $request->engine)
            ->where('volume', $request->volume)
            ->pluck('transmission');
    }

    /**
     * Получить id автомобиля
     * @param Request $request
     * @return mixed
     */
    public function getCarId(Request $request)
    {
        return DB::table('carsbase')->distinct()
            ->where('mark', $request->mark)
            ->where('model', $request->model)
            ->where('engine-type', $request->engine)
            ->where('volume', $request->volume)
            ->where('transmission', $request->transmission)
            ->pluck('id')
            ->first();
    }

}
