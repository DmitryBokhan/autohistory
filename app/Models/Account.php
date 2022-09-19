<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
     * Операции прихода/расхода
     */
    public function operation()
    {
        return $this->hasOne(Operation::class);
    }

    /*
     * Инвестиционная схема
     */
    public function  investScheme()
    {
        return $this->hasOne(InvestScheme::class);
    }

    /*
     * Цели инвестиуий
     */
    public function payPurpose()
    {
        return $this->hasOne(PayPurpose::class);
    }


    /**
     * Получить баланс свободных средств пользователя
     * @param $user_id
     * @return float
     */
    public function getBalance($user_id)
    {
       return Account::where('user_id', $user_id)->get()->sum('sum');
    }

    /**
     * Получить баланс всех инвестированных средств пользователя
     * @param $user_id
     * @return float
     */
    public function getBalanceInvest($user_id)
    {
        $balance = Account::where('user_id', $user_id)->where('operation_id', 7)->where('status', 'OPEN')->get()->sum('sum');
        return abs($balance);
    }


    /**
     * Добавить инвестицию в позицию
     * @param $user_id int
     * @param $sum float
     * @param $position_id int
     * @param $invest_schema_id int
     * @param $invest_percent float
     * @param $invest_fixed float
     * @param $pay_purpose_id int
     * @param $comment string
     * @return void
     */
    public function addInvestPosition($user_id, $sum, $position_id, $invest_schema_id, $invest_percent = null, $invest_fixed = null, $pay_purpose_id, $comment = null)
    {
        $sum_prepare = $sum > 0 ? -1 * $sum : $sum; // преобразуем в отрецательное число

        Account::create([
            'user_id' => $user_id,
            'operation_id' => 7,
            'sum' =>  $sum_prepare,
            'position_id' => $position_id,
            'invest_schema_id' => $invest_schema_id,
            'invest_percent' => $invest_percent,
            'invest_fixed' => $invest_fixed,
            'pay_purpose_id' =>$pay_purpose_id,
            'comment' => $comment,
            'status' => 'OPEN'
        ]);
    }

    /**
     * Установить статус инвестиции как закрытый
     * @param $account_id
     * @return void
     */
    protected function setStatusClosed($account_id)
    {
        Account::where('id', $account_id)->update(['status' => 'CLOSED']);
    }

    /**
     * Получить все открытые инвестиции по id позиции
     * @param $position_id
     * @return array
     */
    public function getOpenAccountsInPosition($position_id)
    {
        return Account::where('position_id', $position_id)->where('status', 'OPEN')->get();
    }


    /**
     * Добавить свободные средства на счет инвестора
     * @param $request
     * @return void
     */
    public function addDepositIntoAccount($user_id, $sum)
    {
        Account::create([
            'user_id' => $user_id,
            'sum' => $sum,
            'operation_id' => 1 //зачисление свободных средств на счет инвестора
        ]);
    }

    public function CalculateAccount($account_id)
    {
        $account = Account::find($account_id);
        $schema = $account->invest_schema_id;
        switch($schema)
        {
            case(1): //"% от вклада"
                return "";
                break;
            case(2): //% от прибыли
                return "";
                break;
            case(3): //фиксированная сумма
                return "";
                break;
            case(4): //без схемы расчета
                return "";
                break;
        }

    }


}
