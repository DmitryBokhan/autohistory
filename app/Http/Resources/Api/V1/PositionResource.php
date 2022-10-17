<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{
    /**
     * Класс для вывода информации для раздела Позиции->Все позиции (список позиций)
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            "id" => $this->id,
            "user_id" => $this->user_id,
            "user_name" => $this->user->name,
            "position_status" => $this->positionStatus->name,
            "car_id" => $this->car_id,
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
            "city_id" => $this->city_id,
            "preparation_start" => $this->preparation_start,
            "preparation_plan" => $this->preparation_plan,
            "preparation_end" => $this->preparation_end,
            "additional_cost_plan" => $this->additional_cost_plan,
            "additional_cost_fact" => $this->additional_cost_fact,
            "delivery_cost_plan" => $this->delivery_cost_plan,
            "delivery_cost_fact" => $this->delivery_cost_fact,
            "comment" => $this->comment,
        ];
    }
}
