<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\InvestResouce;
use App\Models\InvestScheme;
use App\Models\PayPurpose;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class ApiInvestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $position = Position::find($request->id);

        //если автомобиль получен "под реализацию", то исключаем из списка возможных целей инвестирования пункт "Покупка автомобиля"
        if($position->is_realization == true){
            $pay_purposes = PayPurpose::where("id", "<>", 1)->get()->makeHidden(['created_at', 'updated_at']);
        }else{
            $pay_purposes = PayPurpose::get()->makeHidden(['created_at', 'updated_at']);
        }

        $investors = User::where('is_active', true)->get()->makeHidden(['created_at', 'updated_at', 'email', 'email_verified_at', 'is_active']);

        $invest_schemes = InvestScheme::get()->makeHidden(['created_at', 'updated_at']);

        return new InvestResouce([
            "pay_purpose" => $pay_purposes, //цели инвестирования
            "investors" => $investors, //инвесторы (включая админов)
            "invest_schemes" => $invest_schemes]);//схемы инвестирования
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
