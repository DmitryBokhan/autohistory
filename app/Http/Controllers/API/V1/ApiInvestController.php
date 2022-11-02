<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invest\StoreRequest;
use App\Http\Resources\Api\V1\InvestResource;
use App\Models\Account;
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
     * @return InvestResource
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

        return new InvestResource([
            "pay_purpose" => $pay_purposes, //цели инвестирования
            "investors" => $investors, //инвесторы (включая админов)
            "invest_schemes" => $invest_schemes]);//схемы инвестирования
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StoreRequest $request)
    {
        $position = Position::find($request->position_id);

        if($position->position_status_id == 2){
            return response()->json(array('error' => 'Для добавления инвестиции, позиция должна находиться в статусе "Подготовка"'))->setStatusCode(200);
        }elseif($position->position_status_id == 3){
            return response()->json(array('error' => 'Операция отклонена. Целевая позиция находится в статусе "Архив".'))->setStatusCode(200);
        }

        $request->validated();

        $user_id = $request->investors;
        $sum = $request->sum;
        $position_id = $request->position_id;
        $invest_scheme_id = $position->user_id == $request->investors ? 4 : $request->schemes; //если инвестор == хозяин позиции, тогда инвестиция "без схемы расчета"
        $invest_percent = $invest_scheme_id == 1 ? User::find($user_id)->invest_percent : null; //устанавливаем процент инвестиций пользователя
        $invest_fixed = $invest_scheme_id == 3 ? str_replace(" ", "", $request->invest_fixed) : null;
        $comment = $request->comment;
        $sum = str_replace(" ", "", $sum);
        $pay_purpose_id = $request->pay_purposes;

        try {
            Account::addInvestPosition($user_id, $sum, $position_id, $invest_scheme_id, $invest_percent, $invest_fixed, $pay_purpose_id, $comment);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('error' => 'Произошла ошибка при добавлении инвестиции'))->setStatusCode(422);
        }

        return response()->json(array('message' => 'Инвестиция успешно добавлена'))->setStatusCode(201);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function destroy(Request $request)
    {

        $account = Account::find($request->account_id);

        $position = Position::find($account->position_id);

        if($position->position_status_id == 2){ //если позиция в продаже
            return response()->json(array('error' => 'Для удаления инвестиции, позиция должна находиться в статусе "Подготовка"'))->setStatusCode(200);
        }elseif($position->position_status_id == 3){ //если позиция в архиве
            return response()->json(array('error' => 'Операция отклонена. Позиция назодится в статусе "Архив".'))->setStatusCode(200);
        }

        if($account->status == "OPEN"){ //счет имеет статус OPEN
            Account::deleteAccount($request->account_id);
            return response()->json(array('message' => 'Инвестиция успешно удаленна'))->setStatusCode(201);
        }else{
            return response()->json(array('error' => 'Операция отклонена. Инвестиуия не является открытой'))->setStatusCode(200);
        }


    }
}
