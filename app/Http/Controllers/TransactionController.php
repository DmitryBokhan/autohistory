<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index()
    {

        $investors = User::where('id','<>', Auth::User()->id)->where('is_active', true)->get(); //получим всех пользователей кроме себя

        return view('finance.transaction', compact(['investors']));
    }

    public function store(StoreRequest $request)
    {
        $sum = abs(str_replace(" ", "", $request->sum));

        Account::addAccount(Auth::User()->id, -$sum, 9); //списание со своего счета
        Account::addAccount($request->user, $sum, 6); // зачисление на другой счет

        return redirect()->route('transaction.index')
            ->with('success','Перевод успешно выполнен');
    }
}
