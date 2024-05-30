<?php

namespace App\Services\User;

use App\Enums\Booking\BookingStatus;
use App\Enums\Room\PriceType;
use App\Models\Booking;
use App\Models\DeviceRoom;
use App\Models\Room;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RoomService extends BaseService
{
    public function getModel()
    {
        return Room::class;
    }

    /**
     * @param array $request
     * @return Collection
     */
    public function searchByCondition(array $request): Collection
    {
        $arrangedRooms = $this->searchRoomList($request);
        $bookedRoomIds = $this->getBookedRoomIds($request['checkin'], $request['checkout']);

        // Loại bỏ các phòng đã được đặt trước trong thời gian yêu cầu
        return $arrangedRooms->reject(function ($room) use ($bookedRoomIds) {
            return in_array($room['id'], $bookedRoomIds);
        });
    }

    /**
     * @param array $request
     * @return mixed
     */
    private function searchRoomList(array $request): mixed
    {
        $checkIn = Carbon::parse($request['checkin'])->subHour();
        $checkOut = Carbon::parse($request['checkout'])->addHour();

        //* Query các phòng thỏa mãn điều kiện
        $query = $this->model->query();

        // lấy danh sách các phòng thuộc branch có địa chỉ tại thành phố yêu cầu
        $query->whereHas('branch', function ($query) use ($request) {
            $query->where('city', $request['city']);
        });
        //Loại bỏ các phòng đang được sử dụng trong thời gian yêu cầu
        /** Giải thích
         * Khách A đã đặt phòng  từ 16/05 22:00 đến 18/05 06:00
         * Hôm nay là 17/05 thì khách A đổi ý sẽ check out lúc 19/05 06:00
         * -> Khi đó ta ko cập nhật checkout_booking vì để tính thời gian khách trả phòng trễ
         * - Cập nhật lại ở pivot column để lưu thời gian checkout mới
         * --> khi đó khách B muốn tìm phòng thuê từ 18/05 sẽ bỏ qua phòng trễ checkout trễ này
         */
        $query->whereDoesntHave('roomBookings', function ($query) use ($checkIn, $checkOut) {
            $query->whereBetween('checkin_at', [$checkIn, $checkOut])
                ->orWhereBetween('checkout_at', [$checkIn, $checkOut]);
        })->get();

        return $query->get();
    }

    /**
     * @param string $checkIn
     * @param string $checkOut
     * @return array
     */
    private function getBookedRoomIds(string $checkIn, string $checkOut): array
    {
        //* Lấy các phòng đã được đặt trước trong thời gian yêu cầu
        $bookings = Booking::where('booking_checkin', '<', $checkOut)->where('booking_checkout', '>', $checkIn)
            ->whereNotIn('status', BookingStatus::getDeActiveBooking())->get();
        $bookedRoomIds = [];

        foreach ($bookings as $booking) {
            //Lấy ids của các phòng được chỉ định cho đơn đặt trước
            $roomIds = $booking->bookingRooms->pluck('id');
            // Cập nhật danh sách Id phòng đã được đặt trước
            $bookedRoomIds = array_unique(array_merge($bookedRoomIds, $roomIds->toArray()));
        }
        return $bookedRoomIds;
    }

    public function allocateRooms(array $roomsOfBranch, array $request, int $time): array
    {
        $data = [];
        foreach ($roomsOfBranch as $roomOfBranch) {
            $roomsCapacity = $this->calculateCapacity($roomOfBranch['rooms']);
            $branchCapacity = [
                'adults' => array_sum(array_column($roomsCapacity, 'adult_capacity')),
                'children' => array_sum(array_column($roomsCapacity, 'children_capacity'))
            ];
            //Nếu chi nhánh có đủ sức chứa thì tiếp tục tính toán để xếp phòng
            if (($branchCapacity['children'] + $branchCapacity['adults']) >= ($request['adults'] + $request['children'])
                && $branchCapacity['adults'] >= $request['adults']
            ) {
                $roomAllocated = $this->separateRoom($request['adults'], $request['children'], collect($roomsCapacity));
                $roomList = $this->syncRoomsInfo($roomAllocated, $time);
                $totalPrice = $this->getTotalPrice($roomList);
                $data[] = [
                    'branch' => $roomOfBranch['branch'],
                    'rooms' => $roomList,
                    'total_price' => $totalPrice,
                ];
            }
        }
        return $data;
    }

    /**
     * @param array $rooms
     * @return array
     */
    private function calculateCapacity(array $rooms): array
    {
        $data = [];
        //Tính sức chứa tối đa của từng phòng
        foreach ($rooms as $room)
        {
            $single = DeviceRoom::where('room_id', $room['id'])->where('device_id', 1)->sum('quantity');
            $double = DeviceRoom::where('room_id', $room['id'])->where('device_id', 2)->sum('quantity');
            $twin = DeviceRoom::where('room_id', $room['id'])->where('device_id', 3)->sum('quantity');
            $family = DeviceRoom::where('room_id', $room['id'])->where('device_id', 4)->sum('quantity');
            $adult = $single*config('constants.room_capacity.single.adults')
                  + $double*config('constants.room_capacity.double.adults')
                  + $twin*config('constants.room_capacity.twin.adults')
                  + $family*config('constants.room_capacity.family.adults');
            $children = $single*config('constants.room_capacity.single.children')
                    + $double*config('constants.room_capacity.double.children')
                    + $twin*config('constants.room_capacity.twin.children')
                    + $family*config('constants.room_capacity.family.children');
            // Chỉ lấy các phòng có sức chứa > 0
            if(($adult + $children) > 0)
            {
                $data[] = [
                    'room_id' => $room['id'],
                    'single_bed' => $single,
                    'double_bed'=> $double,
                    'twin_bed'=> $twin,
                    'family_bed' => $family,
                    'adult_capacity' => $adult,
                    'children_capacity' => $children
                ];
            }
        }

        //Sắp xếp lại theo thứ tự giảm dần
        usort($data, function($a, $b) {
            $totalA = $a['adult_capacity'] + $a['children_capacity'];
            $totalB = $b['adult_capacity'] + $b['children_capacity'];

            if ($totalA == $totalB) {
                return 0;
            }
            return ($totalA < $totalB) ? 1 : -1;
        });
        return $data;
    }

    /**
     * @param int $adults
     * @param int $children
     * @param Collection $roomCapacity
     * @return int[]
     */
    private function separateRoom(int $adults, int $children, Collection $roomCapacity): array
    {
        $separateRooms = [];
        while ($adults > 0 || $children > 0)
        {
            $total = $adults + $children;
               // Tìm phòng có sức chứa phù hợp nhất cho người lớn
            $adultRoom = $roomCapacity->sortByDesc('adult_capacity')->first(function ($item) use ($adults) {
                   return $adults >= $item['adult_capacity'];
            });
               // Tìm phòng có sức chứa phù hợp nhất cho trẻ em
            $childrenRoom = $roomCapacity->sortByDesc('children_capacity')->first(function ($item) use ($total, $children) {
                   return $children >= $item['children_capacity'] && $total <= $item['adult_capacity'] +  $item['children_capacity'];
            });

            // Ưu tiên xếp người lớn vào các phòng phù hợp
            if ($adultRoom && $adults >= $children) {
                $separateRooms[] = $adultRoom;
                $adults -= $adultRoom['adult_capacity'];
                $children -= $adultRoom['children_capacity'];
                $roomCapacity->forget($roomCapacity->search($adultRoom));
            }
            //Nếu số trẻ em nhiều hơn, ưu tiên sắp xếp trẻ em vào các phòng
            else if ($childrenRoom && $adults < $children) {
                $separateRooms[] = $childrenRoom;
                $children -= $childrenRoom['children_capacity'];
                // Nếu như thừa slot của người lớn thì sẽ để trẻ em bù vào chỗ trống đó
                $vacantlyAdultSlot = $childrenRoom['adult_capacity']- $adults;
                if($vacantlyAdultSlot >= 0)
                {
                    $adults = 0;
                    $children -= $vacantlyAdultSlot;
                } else {
                    $adults -= $childrenRoom['adult_capacity'];
                }
                $roomCapacity->forget($roomCapacity->search($childrenRoom));
            }
            // Nếu không có phòng phù hợp, xếp phòng có sức chứa người lớn nhỏ nhất có thể sao cho lớn hơn số lượng cần
            else {
                $tempRoom =  $roomCapacity->sortBy('adult_capacity')->first(function ($item) use ($adults) {
                    return $adults <= $item['adult_capacity'];
                });
                $separateRooms[] = $tempRoom;
                $adults -= $tempRoom['adult_capacity'];
                $children -= $tempRoom['children_capacity'];
                $roomCapacity->forget($roomCapacity->search($tempRoom));
            }
        }
        return $separateRooms;
    }

    public function syncRoomsInfo(array $separatedRooms, int $bookingHour)
    {
        $rooms = collect();
        $duplicatedRoom = false;

        // tính tiền thuê từng phòng
         foreach ($separatedRooms as $separatedRoom)
         {
             $room = $this->find($separatedRoom['room_id']);
             // Lấy phòng có thôgn tin bị trùng
             if(!$rooms->isEmpty()) {
                 $duplicatedRoom = $rooms->search(function ($item) use ($room, $separatedRoom) {
                     return $item['room_type'] == $room->roomType->name
                         && $item['single_bed'] ==  $separatedRoom['single_bed']
                         && $item['double_bed'] ==  $separatedRoom['double_bed']
                         && $item['twin_bed'] ==  $separatedRoom['twin_bed']
                         && $item['family_bed'] ==  $separatedRoom['family_bed'];
                 });
             }
            //Thêm phòng mới nếu không bị trùng hoặc danh sách đang rỗng
             if($duplicatedRoom === false || $rooms->isEmpty()) {
                 if ($bookingHour < 24)
                 {
                     $priceHourly = $room->roomType->roomPrices->first(function ($item) {
                         return $item['type_price'] == PriceType::ListedHourPrice['value'];
                     });
                     $priceFirstHour = $room->roomType->roomPrices->first(function ($item) {
                         return $item['type_price'] == PriceType::First2Hours['value'];
                     });

                     $priceUnit =  [
                         'hourly' => $priceHourly['price'],
                         'firstHour' => $priceFirstHour['price'],
                     ];
                     $totalPriceARoom = $priceFirstHour['price']*2 + $priceHourly['price']*ceil($bookingHour-2 > 0 ?? 0);

                 } else {
                     $pricePerDay = $room->roomType->roomPrices->first(function ($item) {
                         return $item['type_price'] == PriceType::ListedDayPrice['value'];
                     });
                     $priceUnit = [
                         'perDay' => $pricePerDay['price'],
                     ];
                     $totalPriceARoom = $pricePerDay['price']*ceil($bookingHour/24);
                 }

                 $rooms = $rooms->push([
                     "room_ids" => [$room->id],
                     "room_type" => $room->roomType->name,
                     "room_type_id" => $room->roomType->id,
                     "single_bed" => $separatedRoom['single_bed'],
                     "double_bed" => $separatedRoom['double_bed'],
                     "twin_bed" => $separatedRoom['twin_bed'],
                     "family_bed" => $separatedRoom['family_bed'],
                     'price_unit' => $priceUnit,
                     'total_price_1_room' => $totalPriceARoom,
                     "adult_capacity" => $separatedRoom['adult_capacity'],
                     "children_capacity" => $separatedRoom['children_capacity'],
                 ]);
             } else {
                 // Cập nhật lại danh sách nếu như đã có phòng bị trùng thông tin
                 $updatedRooms = $rooms->map(function ($item, $key) use ($duplicatedRoom, $separatedRoom){
                     if ($key == $duplicatedRoom) {
                         $item['room_ids'][] = $separatedRoom['room_id'];
                     }
                     return $item;
                 });
                 $rooms = $updatedRooms;
             }
         }
         return $rooms;
    }

    /**
     * Tính tổng tiền phòng ở mỗi chi nhánh
     * @param $rooms
     * @return float|int
     */
    private function getTotalPrice($rooms): float|int
    {
        $totalPrice = 0;
        foreach ($rooms as $room)
        {
            $totalPrice += count($room['room_ids']) * $room['total_price_1_room'];
        }
        return $totalPrice;
    }
}
