<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:permissions'
    ];

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
                return self::$rules;
            }
            case 'PUT': {
                return self::updateRules($this->permission->id);
            }
            default:break;
        }
    }

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    private static function updateRules($id)
    {
        return [
            'name' => 'sometimes|required|unique:permissions,name,' . $id
        ];
    }
}
