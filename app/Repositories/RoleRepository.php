<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
 */

class RoleRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
}
