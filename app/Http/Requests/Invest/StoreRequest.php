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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        if($request->pay_purposes == 1) {
            if($request->schemes == 3 ){
                return [
                    'sum' => ['required', new MaxCostInvestOnPurchasePosition, new InvestorHasMoney],
                    'invest_fixed' => 'required'
                ];
            }else{
                return [
                    'sum' => ['required', new MaxCostInvestOnPurchasePosition, new InvestorHasMoney],
                ];
            }
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
