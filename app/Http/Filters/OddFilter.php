<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class OddFilter extends BaseFilter
{
    /**
     * @param int $id
     */
    public function market(int $id)
    {
        $this->builder->where('market_id', $id);
    }
}
