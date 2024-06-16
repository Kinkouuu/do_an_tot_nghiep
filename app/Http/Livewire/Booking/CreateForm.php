<?php

namespace App\Http\Livewire\Booking;

use App\Services\User\BranchService;
use App\Services\User\RoomService;
use Carbon\Carbon;
use Livewire\Component;

class CreateForm extends Component
{
    public $branches;
    public $roomTypes;
    public $minCheckin;
    public $minCheckout;
    public $branchSelected;
    public $roomTypeSelected;
    public $checkin;
    public $checkout;
    public  function __construct($id = null)
    {
        parent::__construct($id);
        $this->minCheckin = Carbon::now()->format('Y-m-d H:i');
    }

    public function render()
    {
        return view('livewire.booking.create-form');
    }

    public function setMinCheckOut($timeCheckin)
    {
        $this->minCheckout = Carbon::parse($timeCheckin)->addHours(2);
    }
}
