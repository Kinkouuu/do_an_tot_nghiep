<?php

namespace App\Listeners;

use App\Enums\Booking\BookingStatus;
use App\Events\BookingEvent;
use App\Models\BookingRoom;
use App\Models\Room;
use App\Services\User\BookingService;
use App\Services\User\RoomService;
use Carbon\Carbon;
use DB;
use Log;

class SeperatedRooms
{
    protected BookingService $bookingService;
    protected RoomService $roomService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BookingService $bookingService, RoomService $roomService)
    {
        $this->bookingService = $bookingService;
        $this->roomService = $roomService;
    }

    /**
     * Handle the event.
     *
     * @param BookingEvent $event
     * @return void
     */
    public function handle(BookingEvent $event): void
    {
        $booking = $event->booking;
        $rooms = $event->roomInfo['rooms'];
        $bookingCheckIn = Carbon::parse($booking->booking_checkin)->subHour();
        $bookingCheckOut = Carbon::parse($booking->booking_checkout)->addHour();
        $bookingHour = $bookingCheckOut->diffInHours($bookingCheckIn) - 2;
        Log::info('Start separate room for booking ' . $booking->id);
        foreach ($rooms as $room) {
            foreach ($room['room_ids'] as $key=>$roomName) {
                $roomId = $key;
                $bookedRoom = $this->bookingService->roomHasBooked($roomId, $bookingCheckIn, $bookingCheckOut);
                if ($bookedRoom->isEmpty()) {
                    Log::info('Separate room ' . $roomId . ' for booking ' . $booking->id);
                    BookingRoom::create([
                        'booking_id' => $booking->id,
                        'room_id' => $roomId,
                        'price' => $room['total_price_1_room']
                    ]);
                } else {
                    $roomModel = Room::find($roomId);
                    $respectiveRoom = $this->roomService->getRespectiveRoom($roomModel, $bookingCheckIn, $bookingCheckOut)->first();
                    if ($respectiveRoom) {
                        Log::info('Separate room ' . $respectiveRoom->id . ' instead room' . $roomId . ' for booking ' . $booking->id);
                        $prices = $this->roomService->getPrices($respectiveRoom, $bookingHour);
                        BookingRoom::create([
                            'booking_id' => $booking->id,
                            'room_id' => $respectiveRoom->id,
                            'price' => $prices['total_price_1_room']
                        ]);
                    } else {
                        Log::info('Can not found respective room instead room ' . $roomId . ' for booking ' . $booking->id);
                        BookingRoom::create([
                            'booking_id' => $booking->id,
                            'room_id' => $roomId,
                            'price' => $room['total_price_1_room']
                        ]);
                        $booking->status = BookingStatus::Refuse['key'];
                        $booking->refuse_reason = 'Hệ thống tự động hủy do hết phòng';
                        $booking->save();
                        break;
                    }
                }
            }
        }
        Log::info('Completed separate room for booking ' . $booking->id);
    }
}
