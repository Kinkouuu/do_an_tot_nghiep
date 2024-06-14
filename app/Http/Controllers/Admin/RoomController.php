<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use App\Models\Branch;
use App\Models\Room;
use App\Services\Admin\DeviceService;
use App\Services\Admin\RoomService;
use App\Services\Admin\RoomTypeService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    protected RoomTypeService $roomTypeService;
    protected RoomService $roomService;
    protected DeviceService $deviceService;

    public function __construct(RoomTypeService $roomTypeService, RoomService $roomService, DeviceService $deviceService)
    {
        $this->roomTypeService = $roomTypeService;
        $this->roomService = $roomService;
        $this->deviceService = $deviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function index(Request $request)
    {
        $rooms = $this->roomService->getAll($request->all());

        return view('admin.pages.rooms.index', [
            'title' => 'Quản lý phòng',
            'rooms' => $rooms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function create()
    {
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $branches = Branch::all()->sortBy('name');

        return view('admin.pages.rooms.create', [
            'title' => 'Thêm phòng mới vào sử dụng',
            'room_types' => $roomTypes,
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RoomRequest $request)
    {
       $response = $this->roomService->createRoom($request->except('_token'));

       return $this->showAlertAndRedirect($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Room $room
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(Room $room)
    {
        $roomTypes = $this->roomTypeService->getActiveRoomType();
        $branches = Branch::all()->sortBy('name');
        return view('admin.pages.rooms.edit', [
            'title' => 'Cập nhật thông tin phòng',
            'room' => $room,
            'room_types' => $roomTypes,
            'branches' => $branches,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return RedirectResponse
     */
    public function update(RoomRequest $request, Room $room)
    {
       $response = $this->roomService->updateRoom($request->except('_token', '_method'), $room);

       return $this->showAlertAndRedirect($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return Response
     */
    public function destroy(Room $room)
    {
        //
    }

    /**
     * @param int $roomID
     * @return Application|Factory|View|\Illuminate\View\View
     * @throws BindingResolutionException
     */
    public function getDevices(int $roomID)
    {
        $room = $this->roomService->find($roomID);
        $devices = $this->deviceService->all();

        $roomDevices = $this->roomService->getDeviceRoom($room, $devices);

        return view('admin.pages.rooms.devices', [
            'title' => "Trang thiết bị của phòng",
            'room' => $room,
            'room_devices' => $roomDevices,
        ]);
    }
}
