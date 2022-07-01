<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
   /**
     * Отобразить форму для создания нового ресурса.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marks = DB::table('carsbase')->distinct()->pluck('mark');
        return view('positions.create', ['marks' => $marks]);
    }

    public function cars_ajax(Request $request)
    {

        if(isset($request->mark)){
            $models = DB::table('carsbase')->distinct()->where('mark', $request->mark)->pluck('model');
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
}
