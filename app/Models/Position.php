<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City\City;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';

    protected $guarded = [];


    /**
     * Создатель позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * Автомобиль
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function car()
    {
        return $this->hasOne(Carsbase::class, "id", "car_id");
    }


    /**
     * Статус позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function positionStatus()
    {
        return $this->hasOne(PositionStatus::class, 'id', 'position_status_id');
    }


    /**
     * Инвестинии для текущей позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'id', 'position_id');
    }

    /**
     * Город покупки
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * Расситать прибыльность позиции
     * @return mixed
     */
    public function CalcProfit()
    {
       return $this->sale_cost_plan - abs($this->purchase_cost + $this->additional_cost_plan + $this->delivery_cost_plan);
    }

    /**
     * Рассчитать % рентабельности
     * @return float
     */
    public function CalcProfitabilityPercent()
    {
        return round((($this->CalcProfit() / ($this->purchase_cost + $this->additionl_cost_plan + $this->delivery_cost_plan))*100),2,PHP_ROUND_HALF_DOWN);
    }


    /**
     * Рассчитать сумму дохода инветоров в текушей позиции
     * @return float|int
     */
    public function CalcSumProfitInvestors()
    {
        $accounts = Account::getOpenAccountsInPosition($this->id);
        $sum = 0;
        foreach ($accounts as $account)
        {
            if($account->user_id !== $this->user_id)
            {
                $sum += $account->CalcAccountProfit();
            }
        }
        return $sum;
    }

    /**
     * Рассчитать сбственную прибыль в текущей позиции
     * @return float|int
     */
    public function CalcSumProfitOwn()
    {
       return $this->CalcProfit() - $this->CalcSumProfitInvestors();
    }

    /**
     * Получить сумму средств инвестированных на покупку позиции
     * @return float|int
     */
    public function getSumInvestPurchase()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 1)
            ->where('status', 'OPEN')->get()->sum('sum');
        return abs($sum);
    }

    /**
     * Получить процент инвестированных на "ПОКУПКУ ПОЗИЦИИ" средств
     * @return float|int
     */
    public function getPercentInvestPurchase()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 1)
            ->where('status', 'OPEN')->get()->sum('sum');

        if($this->purchase_cost){

            return round((abs($sum) / $this->purchase_cost) * 100,2,PHP_ROUND_HALF_DOWN);
        }
        return 0;
    }

    /**
     * Получить сумму средств инвестированных на "ПОДГОТОВКУ ПОЗИЦИИ"
     * @return float|int
     */
    public function getSumInvestPreparation()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 3)
            ->where('status', 'OPEN')->get()->sum('sum');
        return abs($sum);
    }

    /**
     * Получить процент инвестированных средств на "ПОДГОТОВКУ ПОЗИЦИИ"
     * @return float|int
     */
    public function getPercentInvestPreparation()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 3)
            ->where('status', 'OPEN')->get()->sum('sum');

        if($this->additional_cost_plan){

            return round((abs($sum) / $this->additional_cost_plan) * 100,2,PHP_ROUND_HALF_DOWN);
        }
        return 100;
    }

    /**
     * Получить сумму средств инвестированных на "ДОСТАВКУ ПОЗИЦИИ"
     * @return float|int
     */
    public function getSumInvestDelivery()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 2)
            ->where('status', 'OPEN')->get()->sum('sum');
        return abs($sum);
    }

    /**
     * Получить процент инвестированных средств на "ДОСТАВКУ ПОЗИЦИИ"
     * @return float|int
     */
    public function getPercentInvestDelivery()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 2)
            ->where('status', 'OPEN')->get()->sum('sum');

        if($this->delivery_cost_plan){

            return round((abs($sum) / $this->delivery_cost_plan) * 100,2,PHP_ROUND_HALF_DOWN);
        }
        return 100;
    }

    /**
     * Получить количество позиций созданных пользователем
     * @param $user_id
     * @return mixed
     */
    public function getCountPositionOwn($user_id)
    {
        return Position::where('user_id', $user_id)->where('position_status_id', '<>', 3)->get()->count();
    }
}
