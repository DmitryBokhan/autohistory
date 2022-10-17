<?php

namespace App\Http\Requests\Api\V1\Position;

use App\Http\Requests\Api\V1\ApiRequest;
use App\Rules\MinCostSalePosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if($request->engine_type == "электро") {
            return [
                'mark' => 'required',
                'model' => ['required', Rule::notIn(['Выберите модель'])],
                'engine_type' => ['required', Rule::notIn(['Выберите тип двигателя'])],
                'year' => 'required',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'sale_cost_plan' => ['required', new MinCostSalePosition],
                'country' => 'required',
                'region' => ['required', Rule::notIn(['Выберите регион'])],
                'city' => ['required', Rule::notIn(['Выберите город'])],
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required',
                'delivery_cost_plan' => 'required',

            ];
        }else{
            return [
                'mark' => 'required',
                'model' => ['required', Rule::notIn(['Выберите модель'])],
                'engine_type' => ['required', Rule::notIn(['Выберите тип двигателя'])],
                'engine_volume' => ['required', Rule::notIn(['Выберите объем ДВС'])],
                'transmission' => ['required', Rule::notIn(['Выберите тип КПП'])],
                'year' => 'required|numeric',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'sale_cost_plan' => ['required', new MinCostSalePosition],
                'country_id' => 'required',
                'region_id' => ['required', Rule::notIn(['Выберите регион'])],
                'city_id' => ['required', Rule::notIn(['Выберите город'])],
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required',
                'delivery_cost_plan' => 'required',

            ];
        }
    }
}
