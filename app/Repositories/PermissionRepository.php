<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
 */

class PermissionRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
