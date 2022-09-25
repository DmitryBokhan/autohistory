<?php

namespace App\Http\Requests\Position;

use App\Rules\MinCostSalePosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class UpdateRequest extends FormRequest
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
        if($request->engine_types == "электро") {
            return [
                'marks' => 'required',
                'models' => ['required', Rule::notIn(['Выберите модель'])],
                'engine_types' => ['required', Rule::notIn(['Выберите тип двигателя'])],
                'year' => 'required',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'sale_cost_plan' => ['required', new MinCostSalePosition],
                'countries' => 'required',
                'regions' => ['required', Rule::notIn(['Выберите регион'])],
                'cities' => ['required', Rule::notIn(['Выберите город'])],
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required',
                'delivery_cost_plan' => 'required',

            ];
        }else{
            return [
                'marks' => 'required',
                'models' => ['required', Rule::notIn(['Выберите модель'])],
                'engine_types' => ['required', Rule::notIn(['Выберите тип двигателя'])],
                'engine_volume' => ['required', Rule::notIn(['Выберите объем ДВС'])],
                'transmission' => ['required', Rule::notIn(['Выберите тип КПП'])],
                'year' => 'required|numeric',
                'gos_number' => 'required',
                'purchase_date' => 'required',
                'purchase_cost' => 'required',
                'sale_cost_plan' => ['required', new MinCostSalePosition],
                'countries' => 'required',
                'regions' => ['required', Rule::notIn(['Выберите регион'])],
                'cities' => ['required', Rule::notIn(['Выберите город'])],
                'preparation_start' => 'required',
                'preparation_plan' => 'required',
                'additional_cost_plan' => 'required',
                'delivery_cost_plan' => 'required',

            ];
        }
    }
}
