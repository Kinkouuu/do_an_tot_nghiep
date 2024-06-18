<?php

namespace App\Services\Admin;

use App\Enums\Booking\BookingStatus;
use App\Enums\RoleAccount;
use App\Enums\Room\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\User\RoomService as UserRoomService;

class RoomService extends UserRoomService
{

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

    /**
     * Đổi phòng tương ứng cho đơn đặt
     * @param Booking $booking
     * @param int $roomId
     * @param int $roomChangeId
     * @return array
     */
    public function changeRoom(Booking $booking, int $roomId, int $roomChangeId): array
    {
        $validate = $this->roomIsNowAvailable($booking, $roomChangeId);
        if ($validate)
        {
            $bookingRoom = $booking->bookingRooms()->where('room_id',$roomId)->first();
            $bookingRoom->pivot->room_id = $roomChangeId;
            $bookingRoom->pivot->save();
            return $this->successResponse('Thay đổi phòng thành công!');
        }
       return $this->errorResponse('Phòng này đã được đặt trước hoặc đang không thể sử dụng.', 'VUi lòng chọn phòng khác!');
    }

    /**
     * Check xem phòng có đang trống hoặc đã có đơn hẹn trước không
     * @param Booking $booking
     * @param $roomId
     * @return bool
     */
    public function roomIsNowAvailable(Booking $booking, $roomId): bool
    {
        $roomHasBooked = DB::table('bookings')
            ->leftJoin('booking_room','bookings.id', '=', 'booking_room.booking_id')
            ->where('booking_room.room_id', $roomId)
            ->where('bookings.booking_checkin', '<', $booking['booking_checkout'])
            ->where('bookings.booking_checkout', '>', $booking['booking_checkin'])
            ->whereNotIn('bookings.status', BookingStatus::getDeActiveBooking())
            ->get();
        $roomNotVacating = $this->model->where('id', $roomId)->where('status','!=', RoomStatus::Vacating['key'])->get();

        return $roomHasBooked->isEmpty() && $roomNotVacating->isEmpty();
    }

    /**
     * Lấy các phòng đã được đặt trước trong khoảng thời gian trùng lặp
     * @param array $roomIds
     * @param Carbon $checkIn
     * @param Carbon $checkOut
     * @return mixed
     */
    public function roomsHasBooked(array $roomIds, Carbon $checkIn, Carbon $checkOut): mixed
    {
        return $this->model
            ->whereHas('roomBookings', function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('bookings.booking_checkin', [$checkIn, $checkOut])
                    ->orWhereBetween('bookings.booking_checkout', [$checkIn, $checkOut])
                    ->whereNotIn('bookings.status', BookingStatus::getDeActiveBooking());
            })
            ->whereIn('id', $roomIds)
            ->get();
    }

    /**
     * Cập nhật trạng thái phòng
     * @param array $roomIds
     * @param array $status
     * @return array
     */
    public function changeStatus(array $roomIds, array $status): array
    {
//        DB::beginTransaction();
//        try {
            $this->model->whereIn('id', $roomIds)
                ->update(['status' => $status['key']]);
//            DB::commit();
            return $this->successResponse('Cập nhật trạng thái phòng thành công!');
//        } catch (\Exception $exception) {
//            return $this->successResponse('Đã có lỗi xảy ra!');
//        }
    }
}
