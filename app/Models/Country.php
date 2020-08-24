<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Country
 * @package App\Models
 * @version June 16, 2020, 10:45 am UTC
 *
 * @property string $name
 */
class Country extends Model
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
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:countries',
        'alias' => 'required'
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
            'name' => 'sometimes|required|unique:countries,name,' . $id,
            'alias' => 'sometimes|required'
        ];
    }

    /**
     *
     * @return HasMany
     */
    public function club()
    {
        return $this->hasMany(Club::class);
    }

    /**
     * A Country has one Image
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
        ];
    }
}
