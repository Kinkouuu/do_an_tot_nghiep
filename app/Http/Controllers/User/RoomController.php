<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TypeRoom;
use App\Services\User\RoomTypeService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected RoomTypeService $roomTypeService;

    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    public function getRoomType(string $typeRoomCode)
    {
        $typeRoomId = base64_decode($typeRoomCode);
        $roomType = $this->roomTypeService->find($typeRoomId);
        if(!$roomType) {
            abort(404);
        }

        $roomTypeInfo = $this->roomTypeService->getRoomTypeGlobalInfo($roomType);

        return view('user.pages.rooms.room-type-detail', [
            'page_title' => $roomType->name . ' room',
            'room_type' => $roomTypeInfo,
        ]);
    }
}
