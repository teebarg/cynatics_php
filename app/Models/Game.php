<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\QueryFilter;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{

    use Filterable;
    protected $with = ['gameItems'];

    protected $guarded = [];
    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function rules()
    {
        return [
            'game_date' => 'required|date',
            'market_id' => 'required|exists:markets,id'
        ];
    }

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function updateRules($id)
    {
        return [
            'game_date' => 'sometimes|required|date',
            'game_number' => 'sometimes|required',
            'market_id' => 'sometimes|required|exists:markets,id',
            'game_status_id' => 'sometimes|required|exists:game_statuses,id',
            'settled' => 'sometimes|required|boolean'
        ];
    }

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function oddRules()
    {
        return [
            'odds' => 'array',
            'odds.*' => 'sometimes|required|numeric|exists:odds,id'
        ];
    }

    /**
     *
     * @return HasMany
     */
    public function gameItems()
    {
        return $this->hasMany(GameItem::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function gameStatus()
    {
        return $this->belongsTo(GameStatus::class);
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
    public function odds()
    {
        return $this->morphToMany(Odd::class, 'oddable');
    }

    /**
     *
     * @return BelongsToMany
     */
    public function bookmakers()
    {
        return $this->belongsToMany(Bookmaker::class)->withPivot('booking_number');
    }

    public function toArray()
    {
        return [
            "game_date" => $this->game_date,
            "game_number" => $this->game_number,
            "game_status" => $this->gameStatus,
            "market" => $this->market,
            "settled" => $this->settled,
            "user" => $this->user->username,
            "game_items" => $this->gameItems,
            "id" => $this->id,
            "odds" => $this->odds,
            "bookings" => $this->bookmakers
        ];
    }
}
