<?php

namespace App;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use Filterable;
    protected $fillable = [
        'business_name',
        'rating',
        'views',
        'description',
        'address',
        'phone',
        'email'
    ];

    public $table = 'businesses';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'business_name' => 'required|unique:businesses',
        'rating' => 'sometimes|required',
        'address' => 'required',
        'email' => 'required|email'
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
            'business_name' => 'sometimes|required|unique:businesses,business_name,' . $id,
            'rating' => 'sometimes|required',
            'address' => 'sometimes|required',
            'email' => 'sometimes|required|email'
        ];
    }

    /**
     * A Business has many Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * A Category belongs many Business
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'business_categories');
    }

    /**
     * A Category belongs many Business
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'active' => $this->active,
            'rating' => $this->rating,
            'views' => $this->views,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'categories' => $this->categories,
            'image' => $this->image,
        ];
    }
}
