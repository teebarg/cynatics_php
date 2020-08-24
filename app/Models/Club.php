<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Club
 * @package App\Models
 * @version June 16, 2020, 10:45 am UTC
 *
 * @property string $name
 */
class Club extends Model
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
        'name' => 'required|unique:clubs',
        'alias' => 'required',
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
            'name' => 'sometimes|required|unique:clubs,name,' . $id,
            'alias' => 'sometimes|required',
            'is_active' => 'sometimes|required|boolean',
            'country_id' => 'sometimes|required|exists:countries,id'
        ];
    }

    /**
     * The model's default rules.
     *
     * @return array
     * @var array
     */

    public static function catRules()
    {
        return [
            'competitions' => 'required|array',
            'competitions.*' => 'required|numeric|exists:competitions,id'
        ];
    }

    /**
     *
     * @return BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
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
     * A Club has one Image
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
            "name" => $this->name,
            "alias" => $this->alias,
            "country_id" => $this->country->id,
            "country" => $this->country->name,
            "id" => $this->id,
            "image_id" => $this->image->id ?? null,
            "image" => $this->image->image ?? null,
        ];
    }
}
