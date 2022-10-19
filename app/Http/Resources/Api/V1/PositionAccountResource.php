<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PositionAccountResource extends JsonResource
{


    /**
     * Получить массив данных для списка инвестиций в позиции
     * Используется для заполнения списка инвестиций в позиции
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            "id" => $this->id,
            "investor_name" => $this->user->name,
            "sum" => abs($this->sum),
            "operation_name" => $this->operation->name,
            "invest_scheme_name" => $this->investScheme->name,
            "invest_percent" => $this->invest_percent,
            "invest_fixed" => $this->invest_fixed,
            "pay_purpose_name" => $this->payPurpose->name,
            "status" => $this->status,
            "data" => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
