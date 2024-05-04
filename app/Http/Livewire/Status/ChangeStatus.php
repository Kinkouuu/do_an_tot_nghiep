<?php

namespace App\Http\Livewire\Status;

use Livewire\Component;

class ChangeStatus extends Component
{
    public $item;

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function render()
    {
        return view('livewire.status.change-status');
    }

    public function changeStatus($status)
    {
        $this->item->status = $status;
        $this->item->save();
    }
}
