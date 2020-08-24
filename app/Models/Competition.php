<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Competition
 * @package App\Models
 * @version July 30, 2020, 8:27 am UTC
 *
 */
class Competition extends Model
{

    use Filterable;
    protected $guarded = [];
    protected $with = ['country'];

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
        'name' => 'required|unique:competitions',
        'alias' => 'required|min:3',
        'is_active' => 'sometimes|required|boolean',
        'country_id' => 'required|exists:countries,id'
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
            'name' => 'sometimes|required|unique:competitions,name,' . $id,
            'alias' => 'sometimes|required|min:3',
            'is_active' => 'sometimes|required|boolean',
            'country_id' => 'sometimes|required|exists:countries,id'
        ];
    }

    /**
     *
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * A Competition one Image
     *
     * @return MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "alias" => $this->alias,
            "image_id" => $this->image->id ?? null,
            "image" => $this->image->image ?? null,
            "country_id" => $this->country->id,
            "country" => $this->country->name,
        ];
    }
}
