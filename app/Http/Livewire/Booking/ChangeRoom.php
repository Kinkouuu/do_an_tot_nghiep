<?php

namespace App\Http\Livewire\Booking;

use App\Services\Admin\RoomService;
use Carbon\Carbon;
use Livewire\Component;

class ChangeRoom extends Component
{
    public $roomId;
    public $booking;
    public $roomChangeId;
    protected RoomService $roomService;
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->roomService = app()->make(RoomService::class);

    }

    public function render()
    {
        $bookingRoom = $this->booking->bookingRooms()->where('room_id', $this->roomId)->first();
        $room = $this->roomService->find($this->roomId);
        $checkinAt = $bookingRoom->pivot->checkin_at ?? null;
        $checkOutAt = $bookingRoom->pivot->checkout_at ?? null;
        $respectiveRooms = $checkinAt || $checkOutAt
            ? []
            : $this->roomService->getRespectiveRoom(
                $room,
                Carbon::parse($this->booking['booking_checkin']),
                Carbon::parse($this->booking['booking_checkout']),
                true);
        return view('livewire.booking.change-room', [
            'room' => $room,
            'respectiveRooms' => $respectiveRooms,
            'checkin_at' => $checkinAt ? Carbon::parse($checkinAt)->isoFormat('dddd, HH:mm DD/MM/YYYY') : null,
            'checkout_at' => $checkOutAt ? Carbon::parse($checkOutAt)->isoFormat('dddd, HH:mm DD/MM/YYYY') : null,
            'early' => Carbon::parse($checkinAt)->diffForHumans($this->booking['booking_checkin']),
            'lately' => Carbon::parse($checkOutAt)->diffForHumans($this->booking['booking_checkout']),
        ]);
    }

    public function changeRoom()
    {
        $response = $this->roomService->changeRoom($this->booking, $this->roomId, $this->roomChangeId);
        $this->dispatchBrowserEvent('show-alert', [
            'title' => $response['title'],
            'text' => $response['message'],
            'icon' => $response['status'],
        ]);
    }
}
