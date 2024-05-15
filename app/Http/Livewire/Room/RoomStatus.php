<?php

namespace App\Http\Livewire\Room;

use App\Services\Admin\RoomService;
use Livewire\Component;

class RoomStatus extends Component
{
    public $roomId;
    public $room;
    protected RoomService $roomService;


    public function render()
    {
        $this->roomService = app()->make(RoomService::class);
        $this->room = $this->roomService->find($this->roomId);
        return view('livewire.room.room-status');
    }

    public function changeStatus($status)
    {
        $this->room->status = $status;
        $this->room->save();
    }
}
