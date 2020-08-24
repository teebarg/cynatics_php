<?php

namespace App\Repositories;

use App\Models\Booking;

/**
 * Class BookingRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class BookingRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Booking::class;
    }
}
