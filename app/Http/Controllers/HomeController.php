<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(AppSetting::getDefaultPercentInvest());
        $user_count = User::get()->count();
        $balance = Account::getBalance(auth()->user()->id); //получим баланс свободных средств текущего пользователя
        $balance_invest = Account::getBalanceInvest(auth()->user()->id);////получим баланс инвестированных средств текущего пользователя
        return view('dashboard.home.index', ['user_count' => $user_count, 'balance'=>$balance, 'balance_invest' => $balance_invest]);
    }

}
