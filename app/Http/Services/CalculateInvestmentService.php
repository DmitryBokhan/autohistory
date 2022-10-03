<?php

namespace App\Http\Services;

use App\Models\Position;
use App\Models\Account;

class CalculateInvestmentService
{

    /**
     * Экзептляр класса Position
     * @var Position
     */
    public $position;

    /**
     * Фактическая стоимость продажи
     * @var integer;
     */
    public $sale_cost_fact;

    public function __construct(Position $position, $sale_cost_fact)
    {
        $this->position = $position;

        $this->sale_cost_fact = $sale_cost_fact;
    }

    /**
     * Получить открытые инвестиции в позиции
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOpenAccounts()
    {
        return $this->position->accounts()->where('status', 'OPEN')->get();
    }


    /**
     * Произвести все расчеты по позиции, заполнить факт и перевести в архив
     * @return void
     */
    public function ExecuteCalculation()
    {
        $accounts = $this->getOpenAccounts(); //Получаем все открытые счета в позиции

        $this->position->setSaleCostFact($this->sale_cost_fact); // сохраняем в БД фактическую стоимость позиции
        $this->position->setAdditionalCostFact($this->position->getSumInvestPreparation()); //сохраняем в БД фактическую сумму затрат на подготовку позиции
        $this->position->setDeliveryCostFact($this->position->getSumInvestDelivery());//сохраняем в БД фактическую сумму затрат на доставку позиции


        foreach ($accounts as $account){
            // Зачисляем обратно инвестированные средства на счет инвестора
            $account->addAccount($account->user_id, abs($account->sum), 2, $this->position->id,  $account->invest_scheme_id, null, null, $account->pay_purpose_id);

            // Зачисление прибыли в зависимости от схемы расчета
            switch ($account->invest_scheme_id){
                case(1): // % от вклада
                    $sum = $account->CalcAccountProfit($account->position->sale_cost_fact);
                    Account::addAccount($account->user_id, $sum, 3, $this->position->id, $account->invest_scheme_id, $account->invest_percent, null, $account->pay_purpose_id);
                    break;
                case(2): // % от прибыли
                    $sum = $account->CalcAccountProfit($account->position->sale_cost_fact);
                    Account::addAccount($account->user_id, $sum, 10, $this->position->id, $account->invest_scheme_id, null, null, $account->pay_purpose_id);
                    break;
                case(3): // фиксированная сумма
                    $sum = $account->CalcAccountProfit($account->position->sale_cost_fact);
                    Account::addAccount($account->user_id, $sum, 11, $this->position->id, $account->invest_scheme_id, null, $account->invest_fixed, $account->pay_purpose_id);
                    break;
                    break;
                case(4): // без схемы расчета
                    //ничего не создаем
                    break;
            }

            //Присваеваем счету статуc CLOSED
            $account->setStatusClosed($account->id);

        }
        //Зачисляем прибыль от продажи на счет админа
        Account::addAccount($this->position->user_id, $this->position->CalcSumProfitOwn($this->position->sale_cost_fact), 4, $this->position->id);

        //Переводим позицию в архив
        $this->position->setStatusArchive();
    }
}
