<?php

namespace App\Http\Livewire\Room;

use App\Services\User\BranchService;
use App\Services\User\RoomTypeService;
use Carbon\Carbon;
use Livewire\Component;

class FormSearch extends Component
{
    protected BranchService $branchService;
    public $minCheckin;
    public $minCheckout;
    public $maxChildren;
    public $branchCities;

    public  function __construct($id = null)
    {
        parent::__construct($id);
        $this->branchService = app()->make(BranchService::class);
        $this->branchCities = $this->branchService->getBranchCities();
        $this->minCheckin = Carbon::now()->format('Y-m-d H:i');
        $this->minCheckout = Carbon::now()->addHours(2)->format('Y-m-d H:i');
    }

    public function render()
    {
        return view('livewire.room.form-search');
    }

    public function setMinCheckOut($timeCheckin)
    {
        $this->minCheckout = Carbon::parse($timeCheckin)->addHour();
    }

    public function setMaxChildren($adultNumber)
    {
        $this->maxChildren = $adultNumber*2;
    }
}
