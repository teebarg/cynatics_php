<?php

namespace App\Repositories;

use App\Models\AdSlot;

/**
 * Class AdSlotRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class AdSlotRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdSlot::class;
    }
}
