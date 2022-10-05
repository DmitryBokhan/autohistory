<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Requests\Receipt\StoreRequest;
use App\Models\User;

class ReceiptController extends Controller
{
    /*
     * Форма поступления средств на счет инвестора
     */
    public function index()
    {
        
        $investors = User::where('is_active', true)->get();

        return view('finance.receipt', ['investors' => $investors]);
    }

    /*
     * Сохранить поступление в таблицу прихода
     */
    public function store(StoreRequest $request)
    {
        Account::addAccount($request->user, $request->sum, 1);

        return redirect()->route('receipt.index')
            ->with('success','Счет успешно пополнен');
    }

}
