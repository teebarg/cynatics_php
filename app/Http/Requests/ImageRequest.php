<?php

namespace App\Http\Requests;

use App\Helpers\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ImageRequest extends FormRequest
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
        Validator::extend('is_base64', function($attribute, $value, $params, $validator) {
            return ImageUploader::check_base64_image($value);
        });
        switch ($this->method()) {
            case 'POST':
            case 'PUT': {
                return [
                    'image' => 'required|string'
                ];
            }
            default:break;
        }
    }

}
