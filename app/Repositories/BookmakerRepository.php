<?php

namespace App\Repositories;

use App\Models\Bookmaker;

/**
 * Class BookmakerRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class BookmakerRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bookmaker::class;
    }
}
