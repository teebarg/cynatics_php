<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class BaseFilter extends QueryFilter
{
    const DATE = 'created_at';

    /**
     * @param string $date
     * @param string $column
     */
    public function date(string $date, $column=self::DATE)
    {
        $this->builder->whereDate($column, $date);
    }

    /**
     * @param string $from
     * @param string $column
     */
    public function from(string $from, $column=self::DATE)
    {
        $this->builder->whereDate($column, '>=', $from)
            ->whereDate($column, '<=',$this->request->to ?? Carbon::now());
    }

    /**
     * @param bool $status
     */
    public function isActive($status)
    {
        $boolean = $status === 'true' ? true: false;
        $this->builder->where('is_active', $boolean);
    }

    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $this->builder->where('name', 'ilike', '%' . $name .'%');
    }
}
