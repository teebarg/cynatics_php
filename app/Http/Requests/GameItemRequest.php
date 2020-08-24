<?php

namespace App\Http\Requests;

use App\Models\GameItem;
use Illuminate\Foundation\Http\FormRequest;

class GameItemRequest extends FormRequest
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
                return GameItem::rules();
            }
            case 'PUT': {
                return GameItem::updateRules($this->game_item->id);
            }
            case 'PATCH': {
                return GameItem::oddRules();
            }
            default:break;
        }
    }
}
