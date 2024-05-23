<?php

namespace App\Http\Livewire\Room;

use App\Http\Controllers\User\BookingController;
use Livewire\Component;

class BookingForm extends Component
{
    protected BookingController $bookingController;
    public $roomBranch;
    public $time;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->bookingController = app()->make(BookingController::class);
    }

    public function render()
    {
        return view('livewire.room.booking-form');
    }

    public function storeBooking()
    {
        $this->bookingController->bookingConfirm($this->roomBranch);
    }
}
