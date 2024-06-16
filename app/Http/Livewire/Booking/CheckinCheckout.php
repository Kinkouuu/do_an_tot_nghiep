<?php

namespace App\Http\Livewire\Booking;

use App\Enums\Booking\BookingStatus;
use App\Enums\ResponseStatus;
use Carbon\Carbon;
use Livewire\Component;

class CheckinCheckout extends Component
{
    public $booking;
    public $inRooms = [];
    public $checkInRooms;
    public $selectAllInRooms = false;
    public $outRooms = [];
    public $checkOutRooms;
    public $selectAllOutRooms = false;

    public function render()
    {
        $this->checkInRooms = $this->booking->bookingRooms()->whereNull('booking_room.checkin_at')->get();
        $this->checkOutRooms = $this->booking->bookingRooms()->whereNotNull('booking_room.checkin_at')->whereNull('booking_room.checkout_at')->get();
        //Hoàn thành đơn đặt khi đã checkout tất cả các phòng
        if ($this->checkInRooms->isEmpty() && $this->checkOutRooms->isEmpty())
        {
            $this->booking->status = BookingStatus::Completed['key'];
            $this->booking->save();
        }
        return view('livewire.booking.checkin-checkout', [
            'check_in_rooms' => $this->checkInRooms,
            'check_out_rooms' => $this->checkOutRooms,
        ]);
    }

    /**
     * Chọn tất cả các phòng để checkin
     * @return void
     */
    public function quickCheckIn(): void
    {
        if ($this->selectAllInRooms)
        {
            $this->inRooms = [];
        } else {
            $this->inRooms = $this->checkInRooms->pluck('id');
        }
        $this->selectAllInRooms = !$this->selectAllInRooms;
    }

    /**
     * Chọn tất cả các phòng để checkout
     * @return void
     */
    public function quickCheckOut(): void
    {
        if ($this->selectAllOutRooms)
        {
            $this->outRooms = [];
        } else {
            $this->outRooms = $this->checkOutRooms->pluck('id');
        }
        $this->selectAllOutRooms = !$this->selectAllOutRooms;
    }

    /**
     * Bắt đầu checkin
     * @return void
     */
    public function checkin(): void
    {
        $this->booking->bookingRooms()->updateExistingPivot($this->inRooms, ['checkin_at' => Carbon::now()]);
        $this->dispatchBrowserEvent('show-alert', [
            'title' => 'Check in thành công',
            'text' => null,
            'icon' => ResponseStatus::Success,
        ]);
    }

    /**
     * Hoàn thành checkout
     * @return void
     */
    public function checkout(): void
    {
        $this->booking->bookingRooms()->updateExistingPivot($this->outRooms, ['checkout_at' => Carbon::now()]);
        $this->dispatchBrowserEvent('show-alert', [
            'title' => 'Check out thành công',
            'text' => null,
            'icon' => ResponseStatus::Success,
        ]);
    }
}
