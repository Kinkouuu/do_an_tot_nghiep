<?php

namespace App\Http\Livewire\Room;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class OptionForm extends Component
{
    public $branch;
    public $condition;
    public $rooms;

    public $totalRoomSelected = 0;
    public $totalPrice = 0;
    public $adultsCapacity = 0;
    public $childrenCapacity = 0;
    public $isValidQuantity = false;

    public function render()
    {

        return view('livewire.room.option-form');
    }

    public function decrease(int $index)
    {
        $room = $this->rooms->get($index);

        $quantity = $room['quantity'] ?? 0;
        // Cập nhật lại số lượng đã chọn
        if($quantity > 0) {
            $room['quantity'] = $quantity - 1;
            $this->totalRoomSelected--;
            $this->totalPrice -= $room['total_price_1_room'];
            $this->adultsCapacity -= $room['adult_capacity'];
            $this->childrenCapacity -= $room['children_capacity'];
            $this->isValidQuantity = $this->checkValidQuantity();
        }

        $this->rooms->put($index, $room);
    }

    public function increase(int $index)
    {
        $room = $this->rooms->get($index);

        $quantity = $room['quantity'] ?? 0;
        // Cập nhật lại số lượng đã chọn
        if($quantity < count($room['room_ids'])) {
            $room['quantity'] = $quantity + 1;
            $this->totalRoomSelected++;
            $this->totalPrice += $room['total_price_1_room'];
            $this->adultsCapacity += $room['adult_capacity'];
            $this->childrenCapacity += $room['children_capacity'];
            $this->isValidQuantity = $this->checkValidQuantity();
        }
        $this->rooms->put($index, $room);
    }

    //Check sức chứa tối đa phải đảm bảo đủ số người lớn tối thiểu và tổng số người
    private function checkValidQuantity(): bool
    {
        return $this->adultsCapacity >= $this->condition['adults'] &&
            $this->adultsCapacity + $this->childrenCapacity >= $this->condition['adults'] + $this->condition['children'];
    }

    //Chuẩn hóa lại dữ liệu phòng đã chọn
    private function getRoomSelected()
    {
        $roomList = [];
        foreach ($this->rooms as $room)
        {
            if (isset($room['quantity']) && $room['quantity'] > 0)
            {
                $room['room_ids'] = array_slice($room['room_ids'], 0, $room['quantity']);
                $roomList[] = $room;
            }
        }
        return $roomList;
    }

    public function bookingConfirm()
    {
        $roomsSelected = $this->getRoomSelected();
        Cache::put('cart_' . \Auth::user()->id, [
            'branch' => $this->branch,
            'rooms' => $roomsSelected,
            'total_amount' => [
                'total_room' => $this->totalRoomSelected,
                'total_price' => $this->totalPrice,
            ],
            'condition' => $this->condition,
        ]);
        return redirect()->route('booking.confirm');
    }
}
