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

        $operations = Account::getOperationsList(6);

        return view('finance.transaction', compact(['investors', 'operations']));
    }

    public function store(StoreRequest $request)
    {
        $sum = abs(str_replace(" ", "", $request->sum));

        Account::addAccount(Auth::User()->id, -$sum, 9, null, null, null, null, null, $request->user, null); //списание со своего счета

        $sender_account = Account::where('user_id', Auth::User()->id)->where('sum', -$sum)->where('recipient_id', $request->user)->orderByDesc('created_at')->first(); // получим счет который инициировал перевод средств

        Account::addAccount($request->user, $sum, 6, null, null, null, null, null, null, $sender_account->id); // зачисление на другой счет

        return redirect()->route('transaction.index')
            ->with('success','Перевод успешно выполнен');
    }
}
