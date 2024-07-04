<?php

namespace App\Services\Admin;
use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
use App\Enums\Booking\PaymentType;
use App\Enums\RoleAccount;
use App\Services\User\BookingService as UserBookingService;
use App\Services\User\RoomService as UserRoomService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BookingService extends UserBookingService
{
    protected UserRoomService $roomService;
    public function __construct(UserRoomService $roomService)
    {
        parent::__construct();
        $this->roomService = $roomService;
    }

    public function getAll(?array $request): LengthAwarePaginator
    {
        $data = [];
        $user = auth()->guard('admins')->user();
        if ($user->role == RoleAccount::Admin || is_null($user->branch_id)) {
            $bookings = $this->model->with('bookingRooms')->orderBy('id', 'DESC')->get();
        } else {
            $bookings =$this->model->whereHas('bookingRooms', function($query) use ($user) {
                $query->where('branch_id', $user->branch_id)->orderBy('id', 'DESC');
            })->get();
        }
        foreach ($bookings as $booking)
        {
            $bookingData = $this->roomService->retrieveBookingOrderRooms($booking);
            $type = match ($booking->type) {
                BookingType::OnWebSite => 'Online trên WEB',
                BookingType::OnSociety => 'Qua MXH',
                BookingType::OffLine => 'Offline tại quầy',
            };

            $data[] = [
                'branch_name' => $bookingData['branch']['name'],
                'booking_id' => $booking->id,
                'user' => $booking->user,
                'name' => $booking->name,
                'phone' => $booking->phone,
                'country' => $booking->country,
                'gender' => $booking->gender,
                'citizen_id' => $booking->citizen_id,
                'payment_type' => PaymentType::getValue($booking->payment_type),
                'type' => $type,
                'booking_checkin' => $booking->booking_checkin,
                'booking_checkout' => $booking->booking_checkout,
                'status' => $booking->status,
                'adults' => $booking->number_of_adults,
                'children' => $booking->number_of_children,
                'deposit' => $booking->deposit,
                'created_at' => $booking->created_at,
                'for_relative' => $booking->for_relative,
                'total_room' => $bookingData['total']['total_room'],
                'total_price' => $bookingData['total']['total_price'],
                'total_time' => $bookingData['total']['total_time']
            ];
        }

        return $this->search($request, collect($data));
    }

    /**
     * Xử lý thêm đơn đặt và xếp phòng
     * @param array $request
     * @param array $roomPrices
     * @return array
     */
    public function createBooking(array $request, array $roomPrices): array
    {
        $bookingData = [
            'user_id' => $request['user_id'],
            'phone' => $request['phone'],
            'name' => $request['name'],
            'country' => $request['country'],
            'citizen_id' => $request['citizen_id'],
            'gender' => $request['gender'],
            'deposit' => $request['deposit'],
            'payment_type' => $request['payment'],
            'for_relative' => $request['for_relative'],
            'number_of_adults' => $request['adults'],
            'number_of_children' => $request['children'],
            'type' => $request['type'],
            'booking_checkin' => $request['checkin'],
            'booking_checkout' => $request['checkout'],
            'status' => BookingStatus::Approved['key'],
            'creator' => \Auth::guard('admins')->user()->id,
        ];

        DB::beginTransaction();
        try {
            //Lưu thông tin đơn đặt
            $booking = $this->create($bookingData);
            foreach ($roomPrices as $roomPrice) {
                $booking->bookingRooms()->attach($roomPrice['room']['id'], [
                    'price' => $roomPrice['price']['total_price_1_room']
                ]);
            }
            DB::commit();
            return $this->successResponse('Thêm đơn đặt phòng thành công!', null, 'admin.booking.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getByStatusAndCreatedAtBefore(string $status, Carbon $time)
    {
        return $this->model->where('status', $status)
            ->where('created_at', '<=', $time)
            ->get();
    }
}
