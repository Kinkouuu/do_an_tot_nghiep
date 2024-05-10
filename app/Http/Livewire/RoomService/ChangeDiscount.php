<?php

namespace App\Http\Livewire\RoomService;

use Livewire\Component;

class ChangeDiscount extends Component
{
    public $service;
    public $roomType;
    public $discount;
    public $error;

    public function render()
    {
        return view('livewire.room-service.change-discount');
    }

    public function update($discount)
    {
        if($discount >=0 && $discount <=100)
        {
            $this->roomType->roomServices()->updateExistingPivot($this->service['id'], [
                'discount' => $discount
            ]);
        } else {
            $this->error = 'Mức giảm phải trong khoảng 0-100';
        }
    }
}
