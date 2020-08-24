<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlipItem extends Model
{
    /**
     *
     * @return BelongsTo
     */
    public function slip()
    {
        return $this->belongsTo(Slip::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function home()
    {
        return $this->morphTo();
    }

    /**
     *
     * @return BelongsTo
     */
    public function away()
    {
        return $this->morphTo();
    }
}
