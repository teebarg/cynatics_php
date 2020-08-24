<?php

namespace App\Http\Requests;

use App\Models\Market;
use Illuminate\Foundation\Http\FormRequest;

class MarketRequest extends FormRequest
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
    public function rules()
    {
        switch ($this->method()) {
            case 'POST': {
                return Market::$rules;
            }
            case 'PUT': {
                return Market::updateRules($this->market->id);
            }
            default:break;
        }
    }
}
