<?php

namespace App\Http\Requests\Invest;


use App\Rules\MaxCostInvestOnPurchasePosition;
use App\Rules\InvestorHasMoney;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreRequest extends FormRequest
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
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pay_purposes.required' => 'Выберите цель инвестииции',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        if($request->pay_purposes == 1) {
            if ($request->schemes == 3) {
                return [
                    'sum' => ['required', new MaxCostInvestOnPurchasePosition, new InvestorHasMoney],
                    'invest_fixed' => 'required'
                ];
            } else {
                return [
                    'sum' => ['required', new MaxCostInvestOnPurchasePosition, new InvestorHasMoney],
                ];
            }
        }else if($request->pay_purposes == null){
            return [
                'pay_purposes' => 'required'
            ];

        }else{
            if($request->schemes == 3 ){
                return [
                    'sum' => ['required', new InvestorHasMoney],
                    'invest_fixed' => 'required'
                ];
            }else{
                return [
                    'sum' => ['required', new InvestorHasMoney],
                ];
            }
        }
    }
}
