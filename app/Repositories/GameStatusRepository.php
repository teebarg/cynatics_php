<?php

namespace App\Repositories;

use App\Models\GameStatus;

/**
 * Class GameStatusRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class GameStatusRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return GameStatus::class;
    }
}
