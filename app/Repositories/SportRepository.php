<?php

namespace App\Repositories;

use App\Models\Sport;

/**
 * Class SportRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class SportRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sport::class;
    }
}
