<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameItem extends Model
{
    use Filterable;

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
            'match_date' => 'required|date',
            'game_id' => 'required|exists:games,id',
            'home_id' => 'required|exists:clubs,id',
            'away_id' => 'required|exists:clubs,id',
            'competition_id' => 'required|exists:competitions,id',
            'odd_id' => 'required|exists:odds,id',
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
            'match_date' => 'sometimes|required',
            'result' => 'sometimes|required|string',
            'game_id' => 'sometimes|required|exists:games,id',
            'home_id' => 'sometimes|required|exists:clubs,id',
            'away_id' => 'sometimes|required|exists:clubs,id',
            'game_status_id' => 'sometimes|required|exists:game_statuses,id',
            'competition_id' => 'sometimes|required|exists:competitions,id',
            'odd_id' => 'sometimes|required|exists:odds,id'
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
     * @return BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function home()
    {
        return $this->morphTo();
    }

    /**
     *
     * @return BelongsTo
     */
    public function away()
    {
        return $this->morphTo();
    }

    /**
     *
     * @return BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
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
    public function odd()
    {
        return $this->belongsTo(Odd::class);
    }

    /**
     *
     */
    public function odds()
    {
        return $this->morphToMany(Odd::class, 'oddable');
    }


    public function toArray()
    {
        return [
            "id" => $this->id,
            "home" => $this->home->name ?? '',
            "home_id" => $this->home->id ?? '',
            "home_img" => $this->home->image->image ?? '',
            "away" => $this->away->name ?? '',
            "away_id" => $this->away->id ?? '',
            "away_img" => $this->away->image->image ?? '',
            "competition" => $this->competition->name,
            "competition_id" => $this->competition->id,
            "game_id" => $this->game_id,
            "game_status_id" => $this->game_status_id,
            "game_status" => $this->gameStatus->status,
            "match_date" => $this->match_date,
            "odd" => $this->odd->name,
            "odd_id" => $this->odd->id,
            "odd_type" => $this->odd->market->name,
            "odds" => $this->odds,
            "result" => $this->result,
            "bookie_odd" => $this->bookie_odd
        ];
    }
}
