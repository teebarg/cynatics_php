<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BusinessFilter extends BaseFilter
{
    /**
     * @param string $name
     */
    public function q(string $name)
    {
        $this->builder->Where('business_name', 'like' , '%'. $name .'%')
            ->orWhere('description', 'like' , '%'. $name .'%');
    }
}
