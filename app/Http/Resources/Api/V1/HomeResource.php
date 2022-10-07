<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Account;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    //public static $wrap = 'home';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user_money_free = Account::getBalance($this->id);
        $investors_money_free = Account::getBalanceFreeMoneyInvestors();
        $all_money_free = $user_money_free + $investors_money_free;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'all_money_free' =>$all_money_free,
            'user_money_free' => $user_money_free,
            'investors_money_free' => $investors_money_free,
            ];

    }
}
