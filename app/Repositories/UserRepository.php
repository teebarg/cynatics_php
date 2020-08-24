<?php

namespace App\Repositories;

use App\User;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class UserRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
