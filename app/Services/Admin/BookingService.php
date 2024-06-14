<?php

namespace App\Services\Admin;
use App\Enums\Booking\BookingType;
use App\Enums\Booking\PaymentType;
use App\Enums\RoleAccount;
use App\Services\User\BookingService as UserBookingService;
use App\Services\User\RoomService as UserRoomService;
use Illuminate\Pagination\LengthAwarePaginator;

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
            $bookings = $this->model->with('bookingRooms')->get();
        } else {
            $bookings =$this->model->whereHas('bookingRooms', function($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
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
}
