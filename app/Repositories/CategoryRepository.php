<?php

namespace App\Repositories;

use App\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories
*/

class CategoryRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }
}
