<?php

namespace App\Repositories;

use App\Models\Market;

/**
 * Class MarketRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class MarketRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Market::class;
    }
}
