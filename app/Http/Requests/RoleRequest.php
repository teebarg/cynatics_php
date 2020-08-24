<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:roles'
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
                return self::updateRules($this->role->id);
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
            'name' => 'sometimes|required|unique:roles,name,' . $id
        ];
    }
}
