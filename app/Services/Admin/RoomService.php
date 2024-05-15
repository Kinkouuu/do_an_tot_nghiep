<?php

namespace App\Services\Admin;

use App\Enums\RoleAccount;
use App\Models\Room;
use App\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoomService extends BaseService
{
    public function getModel()
    {
        return Room::class;
    }

    /** Lấy danh sách phòng
     * @param array|null $request
     * @return LengthAwarePaginator
     */
    public function getAll(?array $request): LengthAwarePaginator
    {
        $data = [];
        $user = auth()->guard('admins')->user();
        //Check role user
        if ($user->role == RoleAccount::Admin || is_null($user->branch_id)) {
            $rooms =$this->all(); // Nếu là admin||ko thuộc chi nhánh nào thì lấy cả danh sách
        } else {
            $branchID = $user->branch_id;
            $rooms = Room::where('branch_id', $branchID)->get(); // Nếu ko chỉ lấy danh sách phòng thuộc chi nhánh của user
        }
        foreach ($rooms as $room)
        {
            $data[] = [
                'id' => $room->id,
                'name' => $room->name,
                'room_type' => $room->roomType->name,
                'branch' => $room->branch->name,
                'city' => $room->branch->city,
                'status' => $room->status,
            ];
        }

        return $this->search($request, collect($data));
    }

    /**
     * Thêm phòng mới
     * @param array $data
     * @return array
     */
    public function createRoom(array $data): array
    {
        DB::beginTransaction();
        try {
            $room = $this->create($data);
            DB::commit();
            return $this->questionResponse('admin.room.devices', $room->id,'Thêm phòng mới thành công', 'Tiếp tục thêm thiết bị của phòng');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param Room $room
     * @return array
     */
    public function updateRoom(array $data, Room $room): array
    {
        DB::beginTransaction();
        try {
             $this->update($data, $room->id);
            DB::commit();
            return $this->successResponse('Cập nhật thành công', null, 'admin.room.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Lấy thông tin phòng từ ID
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        $room = $this->find($id);

        if(!$room)
        {
            abort(404);
        }
        return $room;
    }

    /**
     * @param Room $room
     * @param Collection $devices
     * @return Collection
     * @throws BindingResolutionException
     */
    public function getDeviceRoom(Room $room, Collection $devices): Collection
    {
        $data = [];
        //Lấy danh sách các thiết bị
        foreach ($devices as $key=>$device)
        {
            $deviceService = app()->make(DeviceService::class);
            $usingQuantity = $deviceService->getRentingAndUsingDevices($device)->equipping_quantity;

            $data[$key] = [
                'id' => $device->id,
                'type' => $device->typeDevice->name,
                'name' => $device->name,
                'brand' => $device->brand,
                'remain' => $device->quantity - $usingQuantity,
                'equipping' => 0,
                'note' => null,
            ];
            foreach ($room->roomDevices as $roomDevice)
            {
                // Cập nhật lại dữ liệu nếu phòng đang có thiết bị
                if($roomDevice->id == $device->id)
                {
                    $pivotData = [
                        'equipping' => $roomDevice->pivot->quantity,
                        'note' => $roomDevice->pivot->note,
                    ];

                    $data[$key] = array_merge($data[$key], $pivotData);
                    break;
                }
            }
        }
        return collect($data)->sortBy('name')->values();
    }

}
