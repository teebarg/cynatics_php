<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
                return Game::rules();
            }
            case 'PUT': {
                return Game::updateRules($this->game->id);
            }
            case 'PATCH': {
                return Game::oddRules();
            }
            default:break;
        }
    }
}
