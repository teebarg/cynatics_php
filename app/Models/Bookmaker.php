<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bookmaker extends Model
{
    protected $guarded = [];

    /**
     * Validation rules
     *
     * @return array
     * @var array
     */

    public static $rules =  [
        'name' => 'required|string|unique:bookmakers',
        'is_active' => 'sometimes|required|boolean',
    ];

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function updateRules($id)
    {
        return [
            'name' => 'sometimes|required|string|unique:bookmakers,name,' . $id,
            'is_active' => 'sometimes|required|boolean',
        ];
    }

    /**
     *
     * @return BelongsToMany
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}
