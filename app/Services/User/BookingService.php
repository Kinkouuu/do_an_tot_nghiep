<?php

namespace App\Services\User;

use App\Models\Booking;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class BookingService extends BaseService
{
    public function getModel()
    {
        return Booking::class;
    }

    public function storeBooking(array $rooms)
    {

    }

}
