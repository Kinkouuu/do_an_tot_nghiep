<?php

namespace App\Http\Livewire\Booking;

use App\Enums\Booking\BookingStatus;
use App\Enums\Room\RoomStatus;
use App\Services\Admin\RoomService;
use Carbon\Carbon;
use Livewire\Component;

class CheckinCheckout extends Component
{
    protected RoomService $roomService;
    public $booking;
    public $inRooms = [];
    public $checkInRooms;
    public $selectAllInRooms = false;
    public $outRooms = [];
    public $checkOutRooms;
    public $selectAllOutRooms = false;

    public function __construct($id = null)
    {
        $this->roomService = app()->make(RoomService::class);
        parent::__construct($id);
    }

    public function render()
    {
        $this->checkInRooms = $this->booking->bookingRooms()->whereNull('booking_room.checkin_at')->get();
        $this->checkOutRooms = $this->booking->bookingRooms()->whereNotNull('booking_room.checkin_at')->whereNull('booking_room.checkout_at')->get();
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
            $this->inRooms = $this->checkInRooms->pluck('id')->toArray();
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
            $this->outRooms = $this->checkOutRooms->pluck('id')->toArray();
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
        $response = $this->roomService->changeStatus($this->inRooms, RoomStatus::Using);
        $this->dispatchBrowserEvent('show-alert', [
            'title' => 'Đang check in....',
            'text' => $response['title'],
            'icon' => $response['status'],
        ]);
    }

    /**
     * Hoàn thành checkout
     * @return void
     */
    public function checkout(): void
    {
        $this->booking->bookingRooms()->updateExistingPivot($this->outRooms, ['checkout_at' => Carbon::now()]);
        $response = $this->roomService->changeStatus($this->outRooms, RoomStatus::Cleaning);
        $this->dispatchBrowserEvent('show-alert', [
            'title' => 'Đang check out...',
            'text' => $response['title'],
            'icon' => $response['status'],
        ]);
    }
}
