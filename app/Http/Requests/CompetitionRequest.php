<?php

namespace App\Http\Requests;

use App\Models\Competition;
use Illuminate\Foundation\Http\FormRequest;

class CompetitionRequest extends FormRequest
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
                return Competition::$rules;
            }
            case 'PUT': {
                return Competition::updateRules($this->competition->id);
            }
            default:break;
        }
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Competition Name is required!',
        ];
    }
}
