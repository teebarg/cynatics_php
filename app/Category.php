<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:categories'
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
            'name' => 'sometimes|required|unique:categories,name,' . $id,
        ];
    }

    /**
     * A Category belongs many Business
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function business()
    {
        return $this->belongsToMany(Business::class);
    }
}
