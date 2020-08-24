<?php

namespace App\Http\Requests;

use App\Models\Slip;
use Illuminate\Foundation\Http\FormRequest;

class SlipRequest extends FormRequest
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
                return Slip::rules();
            }
            case 'PUT': {
                return Slip::updateRules($this->slip->id);
            }
            default:break;
        }
    }
}
