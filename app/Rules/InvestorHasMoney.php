<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class InvestorHasMoney implements Rule, DataAwareRule
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

        $investor_balance = Account::getBalance($this->data['investors']);
        $invest_sum = str_replace(" ", "", $value);
        if($investor_balance <= 0){
            return false;
        }elseif($invest_sum > 0) {
            return $invest_sum > $investor_balance ? false : true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'На счету инвестора недостаточно средств.';
    }
}
