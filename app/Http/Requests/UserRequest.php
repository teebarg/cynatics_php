<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                return [
                    'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ];
            }
            case 'PUT': {
                return [
                    'username' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('users')->ignore($this->user->id)],
                    'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)]
                ];
            }
            default:break;
        }
    }
}
