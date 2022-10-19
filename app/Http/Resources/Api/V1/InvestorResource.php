<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Account;

class InvestorResource extends JsonResource
{
    /**
     * Класс для вывода информации в раздел Инвесторы->Инвесторы (список инвесторов)
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        if($data == null ){
            return ['error' => 'Пользователь не найден'];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'all_money' => Account::getAllMoney($this->id),
            'free_money' => Account::getBalance($this->id),
            'invest_money' => Account::getBalanceInvestOpen($this->id),
            'is_active' => $this->is_active,
        ];
    }
}
