<?php

namespace App\Repositories;

use App\Models\Game;

/**
 * Class GameRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class GameRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Game::class;
    }
}
