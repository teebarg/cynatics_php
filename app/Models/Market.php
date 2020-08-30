<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Country
 * @package App\Models
 * @version June 16, 2020, 10:45 am UTC
 *
 * @property string $name
 */
class Market extends Model implements HasSlug
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
        'name' => 'required|unique:markets',
        'is_active' => 'sometimes|required|boolean'
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
            'name' => 'sometimes|required|unique:markets,name,' . $id,
            'is_active' => 'sometimes|required|boolean'
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function hasSlug()
    {
        return true;
    }

    /**
     *
     * @return HasMany
     */
    public function odds()
    {
        return $this->hasMany(Competition::class);
    }
}
