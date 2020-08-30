<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class GameFilter extends BaseFilter
{
    /**
     * @param bool $market
     */
    public function market($market)
    {
        $this->builder->whereHas('market', function ($query) use ($market) {
            $query->where('slug', 'like', '%' . $market . '%');
        });
    }
}
