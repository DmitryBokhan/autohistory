<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Отобразить список ресурсов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_active_prepare = false;
        $is_active_sale = false;
        $is_active_archive = false;

        if($request->has('prepare_page')) {
            $is_active_prepare = true;
        }elseif($request->has('sale_page')){
            $is_active_sale = true;
        }elseif($request->has('archive_page')) {
            $is_active_archive = true;
        }

        $is_first_active = true;
        if($is_active_prepare || $is_active_sale || $is_active_archive){
            $is_first_active = false;
        }


        $positions_prepare = Position::latest()->where('position_status_id', 1)->paginate(5,$columns = ['*'], 'prepare_page');
        $positions_sale = Position::latest()->where('position_status_id', 2)->paginate(5,$columns = ['*'], 'sale_page');
        $positions_archive = Position::latest()->where('position_status_id', 3)->paginate(5,$columns = ['*'], 'archive_page');
        return view('positions.index',compact('positions_prepare', 'positions_sale', 'positions_archive', 'is_active_prepare', 'is_active_sale', 'is_active_archive', 'is_first_active'))
            ->with('p', (request()->input('prepare_page', 1) - 1) * 5)
            ->with('s', (request()->input('sale_page', 1) - 1) * 5)
            ->with('a', (request()->input('archive_page', 1) - 1) * 5);
    }

   /**
     * Отобразить форму для создания нового ресурса.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marks = DB::table('carsbase')->distinct()->pluck('mark');
        $countries = DB::table('countries')->get();
        $regions = DB::table('regions')->where('country_id', 3159)->get();
        $cities = DB::table('cities')->where('region_id', 4052)->get();
        return view('positions.create', ['marks' => $marks, 'countries' => $countries, 'regions' => $regions,  'cities' => $cities]);
    }

    /**
     * Поместить только что созданный ресурс в хранилище.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->engine_types == "электро") {
            request()->validate([
                'marks' => 'required',
                'models' => 'required',
                'engine_types' => 'required',
                'year' => 'required',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'countries' => 'required',
                'regions' => 'required',
                'cities' => 'required',
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required'

            ]);
        }else{
            request()->validate([
                'marks' => 'required',
                'models' => 'required',
                'engine_types' => 'required',
                'engine_volume' => 'required',
                'transmission' => 'required',
                'year' => 'required',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'countries' => 'required',
                'regions' => 'required',
                'cities' => 'required',
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required'

            ]);
        }

        $user_id = auth()->user()->id;

        if($request->engine_types == "электро") {
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->marks)
                ->where('model', $request->models)
                ->where('engine-type', $request->engine_types)
                ->pluck('id')
                ->first();

        }else{
            $car_id = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->marks)
                ->where('model', $request->models)
                ->where('engine-type', $request->engine_types)
                ->where('volume', $request->engine_volume)
                ->where('transmission', $request->transmission)
                ->pluck('id')
                ->first();
        }

        //dd($request->year);
        //Position::create(array_merge($request->all(), ['user_id' => $user_id, 'car_id' => $car_id, 'position_status_id' => 1 ]));


        Position::create([
            'user_id' => $user_id,
            'position_status_id' => 1,
            'car_id' => $car_id,
            'year' => $request->year,
            'gos_number' => $request->gos_number,
            'purchase_date' => $request->purchase_date,
            'purchase_cost' => $request->purchase_cost,
            'sale_cost_plan' => $request->sale_cost_plan,
            'city_id' => $request->cities,
            'preparation_start' => $request->preparation_start,
            'preparation_plan' => $request->preparation_plan,
            'additional_cost_plan' => $request->additional_cost_plan
        ]);

        return redirect()->route('positions.index')
            ->with('success','Позиция успешно добавлена');
    }

    public function cars_ajax(Request $request)
    {

        if(isset($request->mark)){
            $models = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark)
                ->pluck('model');
            echo '<option selected>Выберите модель</option>';
            foreach ($models as  $model) {
                echo '<option value="'.$model. '">'.$model. '</option>';
            }
         }

        if(isset($request->model)){
            $engine_types = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark_change)
                ->where('model', $request->model)
                ->pluck('engine-type');

            echo '<option selected>Выберите тип ДВС</option>';
            foreach ($engine_types as  $engine_type) {
                echo '<option value="'.$engine_type. '">'.$engine_type. '</option>';
            }
        }

        if(isset($request->engine_type) && $request->engine_type != 'электро'){
            $engine_volumes = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark_change)
                ->where('model', $request->model_change)
                ->where('engine-type',$request->engine_type)
                ->pluck('volume');

            echo '<option selected>Выберите объем ДВС</option>';
            foreach ($engine_volumes as  $engine_volume) {
                echo '<option value="'.$engine_volume. '">'.$engine_volume. '</option>';
            }
        }

        if(isset($request->engine_volume)){
            $transmissions = DB::table('carsbase')
                ->distinct()
                ->where('mark', $request->mark_change)
                ->where('model', $request->model_change)
                ->where('engine-type',$request->engine_type_change)
                ->where('volume', $request->engine_volume)
                ->pluck('transmission');

            echo '<option selected>Выберите тип КПП</option>';
            foreach ($transmissions as  $transmission) {
                echo '<option value="'.$transmission. '">'.$transmission. '</option>';
            }
        }
        //return response()->json(['marks'=>$request->mark, 'models'=>$models]);
    }

    public function city_ajax(Request $request)
    {
        if(isset($request->country)){
            $regions = DB::table('regions')->where('country_id', $request->country)->get();
            echo '<option selected>Выберите регион</option>';
            foreach ($regions as  $region) {
                echo '<option value="'.$region->id. '">'.$region->name. '</option>';
            }
        }

        if(isset($request->region)){
            $cities = DB::table('cities')
                ->where('region_id', $request->region)->get();
            echo '<option selected>Выберите город</option>';
            foreach ($cities as  $city) {
                echo '<option value="'.$city->id. '">'.$city->name. '</option>';
            }
        }

    }

}
