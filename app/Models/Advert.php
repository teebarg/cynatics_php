<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Advert extends Model
{
    use Filterable;

    protected $guarded = [];
    protected $with = ['image'];
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
        'message' => 'string',
        'url' => 'required|string',
        'target' => 'in:_self,_blank',
        'is_active' => 'sometimes|required|boolean',
        'ad_slot_id' => 'required|exists:ad_slots,id'
    ];

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function updateRules()
    {
        return [
            'message' => '',
            'url' => 'sometimes|required|string',
            'target' => 'sometimes|required|in:_self,_blank',
            'is_active' => 'sometimes|required|boolean',
            'ad_slot_id' => 'sometimes|required|exists:ad_slots,id'
        ];
    }

    /**
     * An Advert has one Image
     *
     * @return MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
