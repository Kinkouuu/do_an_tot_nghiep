<?php

namespace App\Http\Livewire\Room;

use Livewire\Component;

class RoomDevice extends Component
{
    public $room;
    public $room_device;
    public $error;

    public function render()
    {
        return view('livewire.room.room-device');
    }

    public function updateEquipQuantity($quantity)
    {
        //Số lượng tối  đa = số lượng đang trang bị + số lượng dữ trữ
        $maxQuantity = $this->room_device['remain'] + $this->room_device['equipping'];
        if($quantity < 0 || $quantity > $maxQuantity)
        {
            $this->error = 'Số lượng phải nằm trong khoảng: 0->' . $maxQuantity;
        } else {
            if($quantity == 0) //Nếu số lượng = 0 thì xóa khỏi bảng
            {
                $this->room->roomDevices()->detach([$this->room_device['id']]);
            } else {
                // Thêm nếu chưa có
                if($this->room_device['equipping'] == 0)
                {
                    $this->room->roomDevices()->attach([$this->room_device['id']], [
                        'quantity' => $quantity,
                    ]);
                } else { // Cập nhật lại số lượng nếu đang có
                    $this->room->roomDevices()->updateExistingPivot([$this->room_device['id']], [
                        'quantity' => $quantity,
                    ]);
                }
            }

            //Update lại dữ liệu để show lên UI
            $this->error = null;
            $this->room_device['equipping'] = $quantity;
            $this->room_device['remain'] = $maxQuantity - $quantity;
        }
    }

    public function updateNote($note)
    {
        $this->room->roomDevices()->updateExistingPivot([$this->room_device['id']], [
            'note' => strlen(trim($note)) > 0 ? trim($note) : null,
        ]);
    }
}
