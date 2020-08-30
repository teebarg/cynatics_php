<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ClubFilter extends BaseFilter
{
    /**
     * @param bool $status
     */
    public function country($status)
    {
        $this->builder->whereHas('country', function ($query) use ($status) {
            $query->where('name', $status);
        });
    }
}
