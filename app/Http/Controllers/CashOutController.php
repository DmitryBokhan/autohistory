<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashOut\StoreRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CashOutController extends Controller
{
    public function index()
    {
        $investors = User::role('admin')->where('id', Auth::User()->id)->where('is_active', true)->get(); //получим всех инвесторов

        $investors = $investors->merge(User::role('investor')->where('is_active', true)->get());

        return view('finance.cashout', compact(['investors']));
    }

    //списать со счета средства
    public function store(StoreRequest $request)
    {

        $sum = abs(str_replace(" ", "", $request->sum));

        Account::addAccount($request->user, -$sum, 8);

        return redirect()->route('cashout.index')
            ->with('success','Средства успешно выведены');

    }
}
