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
     * Расситать прибыльность
     * @return mixed
     */
    public function CalcProfit()
    {
       return $this->sale_cost_plan - $this->purchase_cost + $this->additionl_cost_plan;
    }

    /**
     * Рассчитать % рентабельности
     * @return float
     */
    public function CalcProfitabilityPercent()
    {
        return round(($this->CalcProfit() / $this->purchase_cost + $this->additionl_cost_plan) * 100,2,PHP_ROUND_HALF_DOWN);
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
     * Рассчитать сбственную прибыль в текщей позиции
     * @return float|int
     */
    public function CalcSumProfitOwn()
    {
       return $this->CalcProfit() - $this->CalcSumProfitInvestors();
    }
}
