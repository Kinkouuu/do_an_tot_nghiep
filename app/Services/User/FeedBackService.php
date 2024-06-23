<?php

namespace App\Services\User;

use App\Models\Booking;
use App\Models\FeedBack;
use App\Models\TypeRoom;
use App\Services\BaseService;

class FeedBackService extends BaseService
{
    public function getModel()
    {
        return FeedBack::class;
    }

    /**
     * Tạo đánh giá mới
     * @param Booking $booking
     * @param TypeRoom $roomType
     * @param array $rating
     * @return void
     */
    public function store(Booking $booking, TypeRoom $roomType, array $rating)
    {
        $this->create([
            'booking_id' => $booking['id'],
            'room_type_id' => $roomType['id'],
            'rate_stars' => $rating['point'],
            'comment' => $rating['comment'],
        ]);
    }
}
