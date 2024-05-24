<?php

namespace App\Http\Livewire\Room;

use App\Services\User\BookingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class BookingForm extends Component
{
    protected BookingService $bookingService;
    public $roomBranch;
    public $time;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->bookingService = app()->make(BookingService::class);
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.room.booking-form',[
            'user' => $user
        ]);
    }

}
