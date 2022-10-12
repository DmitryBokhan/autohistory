<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invest\StoreRequest;
use App\Models\Account;
use App\Models\InvestScheme;
use App\Models\PayPurpose;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class InvestController extends Controller
{
    public function create($position_id)
    {
        $position = Position::find($position_id);

        //если автомобиль получен "под реализацию", то исключаем из списка возможных целей инвестирования пункт "Покупка автомобиля"
        if($position->is_realization == true){
            $pay_purposes = PayPurpose::where("id", "<>", 1)->get();
        }else{
            $pay_purposes = PayPurpose::get();
        }

        $investors = User::where('is_active', true)->get();

        $invest_schemes = InvestScheme::get();

        return view('finance.invest', compact('position', 'pay_purposes', 'investors', 'invest_schemes'));
    }

    public function store(StoreRequest $request)
    {
        $position = Position::find($request->position_id);

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
        //dd($request);
        Account::addInvestPosition($user_id, $sum, $position_id, $invest_scheme_id, $invest_percent, $invest_fixed, $pay_purpose_id, $comment);
        return redirect("/position_info/$position_id");
    }


    // Присвоить инвестиции статус DELETED и зачислить сумму обратно на счет инвестора
    public function delete($account_id)
    {

        $position_id = Account::find($account_id)->position_id;
        Account::deleteAccount($account_id);

        return redirect()->route("position_info", $position_id)
            ->with('success','Инвестиция успешно удалена');
    }
}
