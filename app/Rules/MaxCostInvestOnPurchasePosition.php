<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Position;

class MaxCostInvestOnPurchasePosition implements Rule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $position = Position::find($this->data['position_id']);//получаем все данные по позиции

        $purchase_cost = $position->purchase_cost; //стоимость покупки авто

        $sum_invest_purchase = $position->getSumInvestPurchase(); //сумма уже инвестированных средств на покупку позиции

        $sum_invest = str_replace(" ", "", $value);

        return $sum_invest_purchase + $sum_invest >  $purchase_cost ? false : true; //Если сумма инвестиций превышает стоимость покупки автомобиля, то показываем ошибку пользователю

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Вы превысили максимально возможную сумму инвестиции на покупку автомобиля.';
    }
}
