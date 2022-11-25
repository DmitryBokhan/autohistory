<?php

namespace App\Models;

use App\Http\Services\CalculateInvestmentService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City\City;
use Illuminate\Support\Carbon;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';

    protected $guarded = [];


    /**
     * Создатель позиции
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
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
        return $this->hasMany(Account::class);
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
     * Рассчитать прибыльность позиции
     * @return mixed
     */
    public function CalcProfit($sale_cost_fact=null)
    {

        $sale_cost = $sale_cost_fact ? $sale_cost_fact : $this->sale_cost_plan;

        return $sale_cost - $this->purchase_cost - $this->getSumInvestPreparation() - $this->getSumInvestDelivery();

    }

    /**
     * Рассчитать % рентабельности
     * @return float
     */
    public function CalcProfitabilityPercent($sale_cost_fact=null)
    {
        return ($this->CalcProfit($sale_cost_fact) / ($this->purchase_cost + $this->additionl_cost_plan + $this->delivery_cost_plan))*100;

    }


    /**
     * Рассчитать сумму дохода инвесторов в текущей позиции
     * $closed - если true считаем открытые счета, если false - считаем закрытые счета
     * @return float|int
     */
    public function CalcSumProfitInvestors($sale_cost_fact=null)
    {

        $accounts = Account::getAccountsInPosition($this->id);

        $sum = 0;
        foreach ($accounts as $account)
        {
            if($account->user_id !== $this->user_id)
            {
                $sum += $account->CalcAccountProfit($sale_cost_fact);
            }
        }
        return $sum;
    }

    /**
     * Рассчитать собственную прибыль в текущей позиции
     * @return float|int
     */
    public function CalcSumProfitOwn($sale_cost_fact=null)
    {
        //если позиция в архиве и фактическая стоимость уже установлена
        if($this->sale_cost_fact != null ){
            $sale_cost_fact = $this->sale_cost_fact;
        }
       return $this->CalcProfit($sale_cost_fact) - $this->CalcSumProfitInvestors($sale_cost_fact);
    }

    /**
     * Получить сумму средств инвестированных на покупку позиции
     * @return float|int
     */
    public function getSumInvestPurchase()
    {
        $sum = Account::where('position_id', $this->id)
            ->where('pay_purpose_id', 1)
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');
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
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');

        if($this->purchase_cost){

            //return round((abs($sum) / $this->purchase_cost) * 100,2,PHP_ROUND_HALF_DOWN);
            return (abs($sum) / $this->purchase_cost) * 100;
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
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');

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
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');

        if($this->additional_cost_plan){
            return (abs($sum) / $this->additional_cost_plan) * 100;
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
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');

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
            ->wherein('status', ['OPEN', 'CLOSED'])->get()->sum('sum');

        if($this->delivery_cost_plan){
            return (abs($sum) / $this->delivery_cost_plan) * 100;
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

    /**
     * Установить фактическую стоимость продажи
     * @param $cost
     * @return void
     */
    public function setSaleCostFact($cost)
    {
        $this->update(['sale_cost_fact' => $cost]);
    }

    /**
     * Установить фактическую сумму затрат на подготовку
     * @param $cost
     * @return void
     */
    public function setAdditionalCostFact($cost)
    {
        $this->update(['additional_cost_fact' => $cost]);
    }

    /**
     * Установить фактическую сумму затрат на подготовку
     * @param $cost
     * @return void
     */
    public function setDeliveryCostFact($cost)
    {
        $this->update(['delivery_cost_fact' => $cost]);
    }

    /**
     * Меняет статус позиции (подготовка/продажа)
     * @return void
     */
    public function ChangeStatus()
    {
        if($this->position_status_id == 1){
            $this->setPreparationEnd();
            $this->update([
                'position_status_id' => 2,
                ]);
        }elseif($this->position_status_id == 2){
            $this->update([
                'position_status_id' => 1,
            ]);
        }
    }

    /**
     * Переводит позицию в архив
     * @return void
     */
    public function setStatusArchive()
    {
        $this->update([
            'position_status_id' => 3,
        ]);
    }

    /**
     * Установить (сохранить) дату продажи позиции
     * @return void
     */
    public function setSaleDate()
    {
        $date = Carbon::now()->format('Y-m-d');
        $this->update([
            'sale_date' => $date
        ]);
    }

    /**
     * Установить дату окончания подготовки (если она еще не была установлена)
     * @return void
     */
    public function setPreparationEnd()
    {
       if ($this->preparation_end == null){
           $date = Carbon::now()->format('Y-m-d');
           $this->update([
               'preparation_end' => $date
           ]);
       }
    }

    /**
     * Получить количество дней затраченых на подготовку позиции
     * @return int|void
     */
    public function getPreparationFact()
    {
        if($this->preparation_end != null){
            $start = Carbon::parse($this->purchase_date);
            $end = Carbon::parse($this->preparation_end);
            return $start->diffInDays($end);
        }
    }

    /**
     * Произвести все расчеты по инвестициям и закрыть позицию
     * @param $sale_cost_fact
     * @return void
     */
    public function close($sale_cost_fact)
    {

        $calc_position = new CalculateInvestmentService($this, $sale_cost_fact);

        $calc_position->ExecuteCalculation();

    }
}
