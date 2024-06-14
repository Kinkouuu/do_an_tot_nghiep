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
        $room = $this->roomService->find($this->roomId);
        $respectiveRooms = $this->roomService->getRespectiveRoom(
            $room,
            Carbon::parse($this->booking['booking_checkin']),
            Carbon::parse($this->booking['booking_checkout']),
            true
        );
        return view('livewire.booking.change-room', [
            'room' => $room,
            'respectiveRooms' => $respectiveRooms
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
