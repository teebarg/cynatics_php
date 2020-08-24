<?php

namespace App\Repositories;

use App\Models\Odd;

/**
 * Class OddRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class OddRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Odd::class;
    }
}
