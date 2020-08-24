<?php

namespace App\Repositories;

use App\Models\Competition;
use App\Repositories\BaseRepository;

/**
 * Class CompetitionRepository
 * @package App\Repositories
 * @version July 30, 2020, 8:27 am UTC
*/

class CompetitionRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Competition::class;
    }
}
