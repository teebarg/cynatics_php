<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Odd
 * @package App\Models
 * @version June 16, 2020, 10:45 am UTC
 *
 * @property string $name
 */
class Odd extends Model
{
    use Filterable;
    protected $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:odds',
        'is_active' => 'sometimes|required|boolean',
        'market_id' => 'required|exists:markets,id'
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
            'name' => 'sometimes|required|unique:odds,name,' . $id,
            'is_active' => 'sometimes|required|boolean',
            'market_id' => 'sometimes|required|exists:markets,id'
        ];
    }

    /**
     *
     * @return BelongsTo
     */
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    /**
     *
     */
    public function games()
    {
        return $this->morphedByMany(Game::class, 'taggable');
    }

    /**
     *
     */
    public function gameItems()
    {
        return $this->morphedByMany(GameItem::class, 'taggable');
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "is_active" => $this->is_active,
            "market_id" => $this->market->id,
            "market" => $this->market->name
        ];
    }
}
