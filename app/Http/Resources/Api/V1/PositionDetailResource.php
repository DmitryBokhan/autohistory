<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Account;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Детальная информация о позиции
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        if(empty($this->id)){
           return ["error" => "Позиция не найдена"];
        }



        if(in_array($this->position_status_id,[1,2])){
            $accounts = new PositionAccountCollection(Account::where('position_id', $this->id)->where('status', 'OPEN')->get());
        }elseif($this->position_status_id == 3){
            $accounts = new PositionAccountCollection(Account::where('position_id', $this->id)->where('status', 'CLOSED')->get());
        }


        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            //"position_status_id" => $this->position_status_id,
            "position_status" => $this->positionStatus->name,
            //"car_id" => $this->car_id,
            "car_mark" => $this->car->mark,
            "car_model" => $this->car->model,
            "car_volume" => $this->car->volume,
            "car_transmission" => $this->car->transmission,
            "car_engine_type" => $this->car->{'engine-type'},
            "year" => $this->year,
            "gos_number" => $this->gos_number,
            "is_realization" => $this->is_realization,
            "purchase_date" => $this->purchase_date,
            "sale_date" => $this->sale_date,
            "purchase_cost" => $this->purchase_cost,
            "sale_cost_plan" => $this->sale_cost_plan,
            "sale_cost_fact" => $this->sale_cost_fact,
            //"city_id" => $this->city_id,
            "country" => $this->city->country->name,
            "region" => $this->city->region->name,
            "city" => $this->city->name,
            "preparation_start" => $this->preparation_start,
            "preparation_plan" => $this->preparation_plan,
            "preparation_end" => $this->preparation_end,
            "additional_cost_plan" => $this->additional_cost_plan,
            "additional_cost_fact" => $this->additional_cost_fact,
            "delivery_cost_plan" => $this->delivery_cost_plan,
            "delivery_cost_fact" => $this->delivery_cost_fact,
            "comment" => $this->comment,
            'investments' => $accounts,
        ];



    }
}
