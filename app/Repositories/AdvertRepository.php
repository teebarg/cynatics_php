<?php

namespace App\Repositories;

use App\Models\Advert;

/**
 * Class AdvertRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class AdvertRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Advert::class;
    }
}
