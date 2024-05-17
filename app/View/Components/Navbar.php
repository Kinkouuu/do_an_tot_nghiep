<?php

namespace App\View\Components;

use App\Services\User\ServiceService;
use App\Services\User\RoomTypeService;
use App\Services\User\ServiceTypeService;
use Illuminate\View\Component;

class Navbar extends Component
{
    protected RoomTypeService $roomTypeService;
    protected ServiceTypeService $serviceTypeService;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RoomTypeService $roomTypeService, ServiceTypeService $serviceTypeService)
    {
        $this->roomTypeService = $roomTypeService;
        $this->serviceTypeService = $serviceTypeService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $serviceTypes = $this->serviceTypeService->getServiceList();
        return view('components.navbar', [
            'room_types' => $roomTypes,
            'service_types' => $serviceTypes,
        ]);
    }
}
