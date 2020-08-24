<?php

namespace App\Repositories;

use App\Models\Club;

/**
 * Class ClubRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class ClubRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Club::class;
    }
}
