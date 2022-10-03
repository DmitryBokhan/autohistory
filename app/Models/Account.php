<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Пользователь
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /*
     * Операции прихода/расхода
     */
    public function operation()
    {
        return $this->hasOne(Operation::class, 'id', 'operation_id');
    }

    /*
     * Инвестиционная схема
     */
    public function  investScheme()
    {
        return $this->hasOne(InvestScheme::class, 'id', 'invest_scheme_id');
    }

    /*
     * Цели инвестиуий
     */
    public function payPurpose()
    {
        return $this->hasOne(PayPurpose::class, 'id', 'pay_purpose_id');
    }


    /**
     * Получить позицию привязанную к инвестиции
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
       return $this->belongsTo(Position::class);
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
     * Получить баланс всех инвестированных средств пользователя в позиции
     * @param $user_id
     * @return float
     */
    public function getBalanceInvest($user_id)
    {
        $balance = Account::where('user_id', $user_id)->where('operation_id', 7)->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');
        return abs($balance);
    }



    /**
     * Получить баланс всех инвестированных средств пользователя в позиции со статусом OPEN
     * @param $user_id
     * @return float
     */
    public function getBalanceInvestOpen($user_id)
    {
        $balance = Account::where('user_id', $user_id)->where('operation_id', 7)->where('status', 'OPEN')->get()->sum('sum');
        return abs($balance);
    }



    /**
     * Добавить инвестицию в позицию
     * @param $user_id int
     * @param $sum float
     * @param $position_id int
     * @param $invest_scheme_id int
     * @param $invest_percent float
     * @param $invest_fixed float
     * @param $pay_purpose_id int
     * @param $comment string
     * @return void
     */
    public function addInvestPosition($user_id, $sum, $position_id, $invest_scheme_id, $invest_percent = null, $invest_fixed = null, $pay_purpose_id, $comment = null)
    {
        $sum_prepare = $sum > 0 ? -1 * $sum : $sum; // преобразуем в отрецательное число

        Account::create([
            'user_id' => $user_id,
            'operation_id' => 7,
            'sum' =>  $sum_prepare,
            'position_id' => $position_id,
            'invest_scheme_id' => $invest_scheme_id,
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
    public function setStatusClosed($account_id)
    {
        Account::where('id', $account_id)->update(['status' => 'CLOSED']);
    }

    /**
     * Установить статус инвестиции как удаленная инвестиция
     * @param $account_id
     * @return void
     */
    public function setStatusDeleted($account_id)
    {
        Account::where('id', $account_id)->update(['status' => 'DELETED']);
    }

    /**
     * Получить все инвестиции по id позиции
     * @param $position_id
     * @return array
     */
    public function getAccountsInPosition($position_id)
    {
        return Account::where('position_id', $position_id)->wherein('status', ['OPEN', 'CLOSED'])->get();
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
     * Получить все закрытые инвестиции по id позиции
     * @param $position_id
     * @return array
     */
    public function getClosedAccountsInPosition($position_id)
    {
        return Account::where('position_id', $position_id)->where('status', 'CLOSED')->get();
    }

    /**
     * Получить сумму всех инвестированных средств в позицию
     * @return float|int
     */
    public function getSumAccountsInPosition()
    {

        $sum = Account::where('position_id', $this->position_id)
            ->where('operation_id', 7)
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');
        return abs($sum);
    }

    /**
     * Получить сумму всех инвестированных средств по id позиции
     * @return float|int
     */
    public function getSumAccountsInPositionById($position_id)
    {

        $sum = Account::where('position_id', $position_id)
            ->where('operation_id', 7)
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');
        return abs($sum);
    }

    /**
     * Процент инвестиционных средств (по конкретному счету) в общей доле вложений всех инвесторов в позиции
     * Применяется для схемы - % от прибыли
     * @return float|int
     */
    public function getPartPercent()
    {
        $result = (abs($this->sum) / $this->getSumAccountsInPosition()) * 100;
        return $result;
    }

    /**
     * Возвращает значения для заполнения колонки с % в таблице "Инвестиции в позицию"
     * @return float|int|mixed|void|null
     */
    public function showInvestPercent()
    {
        $scheme = $this->invest_scheme_id;

        switch($scheme)
        {
            case(1): //"% от вклада"
                return $this->invest_percent ;
                break;
            case(2): //% от прибыли
                return $this->getPartPercent();
                break;
            case(3): //фиксированная сумма
                return null;
                break;
            case(4): //без схемы расчета
                return null;
                break;
        }
    }


    /**
     *    /**
     * Добавить счет
     * Операции (operation_id):
     * 1 - Зачисление свободных средств
     * 2 - Зачисление вложенных ранее средств
     * 3 - Зачисление % от вклада
     * 4 - Зачисление прибыли от продажи на счет создателя позиции (не включая прибыли от инвестиции)
     * 5 - Зачисление удаленной из позиции инвестиции (возврат)
     * 6 - Зачисление от другого инвестора
     * 7 - Инвестиция в позицию
     * 8 - Вывод свободных средств из системы
     * 9 - Перевод свободных средств другому инвестору
     * 10 - Зачисление доли от прибыли
     * 11 - Зачисление фиксированной прибыли
     * @param $user_id
     * @param $sum
     * @param $operation_id
     * @param $position_id
     * @param $invest_scheme_id
     * @param $invest_percent
     * @param $invest_fixed
     * @param $pay_purpose_id
     * @return void
     */
    public function addAccount($user_id, $sum, $operation_id, $position_id = null, $invest_scheme_id = null, $invest_percent = null, $invest_fixed = null, $pay_purpose_id = null)
    {
        Account::create([
            'user_id' => $user_id,
            'sum' => str_replace(" ", "", $sum),
            'operation_id' => $operation_id, //зачисление свободных средств на счет инвестора
            'position_id' => $position_id,
            'invest_scheme_id' => $invest_scheme_id,
            'invest_percent' => $invest_percent,
            'invest_fixed' => $invest_fixed,
            'pay_purpose_id' => $pay_purpose_id,
            'comment' => "Операцию совершил пользователь: " . Auth::user()->name . " с ID: ". Auth::user()->id,
        ]);
    }

    /**
     * Рассчитать прибыль по инвестиции
     * @return float|int
     */
    public function CalcAccountProfit($sale_cost_fact=null)
    {
        $scheme = $this->invest_scheme_id;
        switch($scheme)
        {
            case(1): //"% от вклада"
                return abs($this->sum) * $this->invest_percent / 100;
            case(2): //% от прибыли
                $position = Position::find($this->position_id);
                $result = $position->CalcProfit($sale_cost_fact) * ($this->getPartPercent() / 100);
                return $result;
            case(3): //фиксированная сумма
                return $this->invest_fixed;
            case(4): //без схемы расчета
                return 0;
        }

    }

    /**
     * Удаляем (устанавливаем статус DELETED для счета) и зачисляем сумму обратно инвестору.
     * @param $account_id
     * @return void
     */
    public function deleteAccount($account_id)
    {

        $account = Account::find($account_id);
        Account::setStatusDeleted($account_id);
        Account::addAccount($account->user_id, abs($account->sum), 5, $account->position_id,  null, null, null, $account->pay_purpose_id);
    }

}
