<?php

namespace App\View\Components;

use App\Services\User\BranchService;
use App\Services\User\RoomTypeService;
use Illuminate\View\Component;

class RoomSearch extends Component
{
    protected RoomTypeService $roomTypeService;
    protected BranchService $branchService;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RoomTypeService $roomTypeService,  BranchService $branchService)
    {
        $this->roomTypeService = $roomTypeService;
        $this->branchService = $branchService;
    }

    /**
     * Get the view / contents that represent the component
     */
    public function render()
    {
        $branchCities = $this->branchService->getBranchCities();
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        return view('components.room-search', [
            'branch_cities' => $branchCities,
            'types' => $roomTypes,
        ]);
    }
}
