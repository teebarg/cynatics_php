<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Sport
 * @package App\Models
 * @version June 16, 2020, 10:45 am UTC
 *
 * @property string $name
 */
class Sport extends Model
{

    protected $guarded = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:sports'
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
            'name' => 'sometimes|required|unique:sports,name,' . $id
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
}
