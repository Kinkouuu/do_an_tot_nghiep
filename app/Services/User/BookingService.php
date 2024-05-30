<?php

namespace App\Services\User;

use App\Models\Booking;
use App\Services\BaseService;
use Carbon\Carbon;

class BookingService extends BaseService
{
    public function getModel()
    {
        return Booking::class;
    }

    public function storeBooking(array $rooms)
    {

    }

    /**
     * @param $condition
     * @return array
     */
    public function retrieveCondition($condition): array
    {
        $checkIn = Carbon::parse($condition['checkin']);
        $checkout = Carbon::parse($condition['checkout']);
        $time = $checkout->diffInHours($checkIn);
        // Làm tròn thêm 1 tiếng nếu dưới 24 giờ
        if ($time < 24) {
            $duration = ceil($time / 1) . ' giờ';
        }
        // Làm tròn lên 1 ngày nếu trên 24 giờ
        else {
            $days = ceil($time / 24);
            $nights = ($days > 1) ? $days - 1 : $days;
            $duration = $days . ' ngày ' . $nights . ' đêm';
        }

        return [
            'checkin' => $checkIn,
            'checkout' => $checkout,
            'duration' => $duration,
            'adults' => $condition['adults'],
            'children' => $condition['children']
        ];
    }

}
