<?php

namespace App\Repositories;

use App\Models\Country;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class CountryRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Country::class;
    }
}
