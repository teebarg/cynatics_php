<?php

namespace App\Http\Requests;

use App\Models\Club;
use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
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
                return Club::$rules;
            }
            case 'PUT': {
                return Club::updateRules($this->club->id);
            }
            case 'PATCH': {
                return Club::catRules();
            }
            default:break;
        }
    }
}
