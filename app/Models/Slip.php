<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slip extends Model
{
    protected $with = ['slipItems'];

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function updateRules($id)
    {
        return [
            'match_date' => 'sometimes|required|date|date_format:m.d.Y',
            'home' => 'sometimes|required|int|exists:clubs,id',
            'away' => 'sometimes|required|int|exists:clubs,id',
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

    public static function rules()
    {
        return [
            'match_date' => 'required|date_format:m-d-Y',
            'home' => 'required|int|exists:clubs,id',
            'away' => 'required|int|exists:clubs,id',
            'competition_id' => 'required|exists:competitions,id',
            'odd_id' => 'required|exists:odds,id'
        ];
    }


    /**
     *
     * @return HasMany
     */
    public function slipItems()
    {
        return $this->hasMany(SlipItem::class);
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
     * @param $slipId
     * @param $newIfNull
     * @return Slip
     */
    public static function getById($slipId, $newIfNull = true)
    {
        $slip = self::find($slipId);
        if($newIfNull && is_null($slip)){
            $slip = new Slip();
            $slip->save();
        }
        $request = app("request");
        $request->core_session->set("slip_id", $slip->id);
        $isLoggedIn = (bool)$request->core_session->get('is_logged_in');
        $userId = $request->core_session->get('user_id');
        if ($isLoggedIn && $userId && !$slip->user) {
            $slip->user_id = $userId;
            $slip->save();
        }
        return $slip;
    }

    public static function getLatestByUserId($userId)
    {
        return self::where("user_id", $userId)->latest()->skip(1)->take(1)
            ->first();
    }
}
