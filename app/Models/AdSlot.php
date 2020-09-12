<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdSlot extends Model
{
    use Filterable;
    protected $guarded = [];
    protected $with = ['adverts'];

    const BANNER = 'banner';
    const FREE_BET = 'free_bet';

    /**
     *
     * @return HasMany
     */
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }
}
