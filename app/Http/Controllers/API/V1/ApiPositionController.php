<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Position\StoreRequest;
use App\Http\Requests\Api\V1\Position\UpdateRequest;
use App\Http\Resources\Api\V1\PositionCollection;
use App\Http\Resources\Api\V1\PositionDetailResource;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPositionController extends Controller
{
    /**
     * Получить коллекцию позиций по ее статусу
     * Статус передается в маршруте
     * Возможные статусы: prepare, sale, archive
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        switch ($request->status){
            case ('prepare'):
                return new PositionCollection(Position::where('position_status_id', 1)->get());
            case ('sale'):
                return new PositionCollection(Position::where('position_status_id', 2)->get());
            case ('archive'):
                return new PositionCollection(Position::where('position_status_id', 3)->get());
            default:
                return ['error' => 'Ошибка. Статус не определен'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\Position\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user_id = auth()->user()->id;

        if($request->engine_type == "электро") {
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark)
                ->where('model', $request->model)
                ->where('engine-type', $request->engine_type)
                ->pluck('id')
                ->first();

        }else{
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark)
                ->where('model', $request->model)
                ->where('engine-type', $request->engine_type)
                ->where('volume', $request->engine_volume)
                ->where('transmission', $request->transmission)
                ->pluck('id')
                ->first();
        }

        try {
            Position::create([
                'user_id' => $user_id,
                'position_status_id' => 1,
                'car_id' => $car_id,
                'year' => (int)$request->year,
                'gos_number' => $request->gos_number,
                'is_realization' => (boolean)$request->is_realization,
                'purchase_date' => $request->purchase_date,
                'purchase_cost' => (int)str_replace(" ", "",$request->purchase_cost),
                'sale_cost_plan' => (int)str_replace(" ", "", $request->sale_cost_plan),
                'city_id' => (int)$request->city_id,
                'preparation_start' => $request->preparation_start,
                'preparation_plan' => (int)$request->preparation_plan,
                'additional_cost_plan' =>  (int)str_replace(" ", "", $request->additional_cost_plan),
                'delivery_cost_plan' => (int)str_replace(" ", "", $request->delivery_cost_plan),
            ]);
        } catch(\Illuminate\Database\QueryException $ex){
            //если прилетело исключение - отдаем ошибку
            return response()->json(['error' => 'Произошла ошибка при сохранении данных'])->setStatusCode(422);
        }
        return response()->json(['message' => 'Позиция успешно создана'])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PositionDetailResource(Position::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        //валидация вынесена в UpdateRequest

        if($request->engine_type == "электро") {
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark)
                ->where('model', $request->model)
                ->where('engine-type', $request->engine_type)
                ->pluck('id')
                ->first();

        }else{
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark)
                ->where('model', $request->model)
                ->where('engine-type', $request->engine_type)
                ->where('volume', $request->engine_volume)
                ->where('transmission', $request->transmission)
                ->pluck('id')
                ->first();
        }

        try{
            Position::find($id)->update([
                'car_id' => $car_id,
                'year' => (int)$request->year,
                'gos_number' => $request->gos_number,
                'purchase_date' => $request->purchase_date,
                'purchase_cost' => (int)str_replace(" ", "",$request->purchase_cost),
                'sale_cost_plan' => (int)str_replace(" ", "", $request->sale_cost_plan),
                'city_id' => (int)$request->city_id,
                'preparation_start' => $request->preparation_start,
                'preparation_plan' => (int)$request->preparation_plan,
                'additional_cost_plan' =>  (int)str_replace(" ", "", $request->additional_cost_plan),
                'delivery_cost_plan' => (int)str_replace(" ", "", $request->delivery_cost_plan),
                'comment' => $request->comment
            ]);

        } catch(\Illuminate\Database\QueryException $ex){
            //если прилетело исключение - отдаем ошибку
            return response()->json(['error' => 'Произошла ошибка при обновлении данных'])->setStatusCode(422);
        }
        return response()->json(['message' => 'Данные позиции успешно обновлены'])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
