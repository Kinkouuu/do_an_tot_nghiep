<?php

namespace App\Services\Admin;

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
use App\Enums\DataType;
use App\Enums\UserStatus;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\User;
use App\Services\BaseService;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AdminService extends BaseService
{

    public function getModel()
    {
        return Admin::class;
    }

    /**
     * @param array $request
     * @return array
     */
    public function adminAuthenticate(array $request): array
    {
        if (Auth::guard('admins')->attempt([
            'account_name' => $request['account_name'],
            'password' => $request['password'],
            'status' => UserStatus::Active
            ])) {
            return $this->successResponse('Đăng nhập trang quản trị thành công',null,'admin.dashboard');
        } else {
           return $this->errorResponse('Tên đăng nhập hoặc mật khẩu sai','Vui lòng thử lại');
        }
    }

    /**
     * @param array $request
     * @return array|Collection
     */
    public function statisticalData(array $request): array
    {
        $from = isset($request['from'] )? Carbon::parse($request['from']) : Carbon::now()->subMonth();
        $to = isset($request['to']) ? Carbon::parse($request['to']) : Carbon::now();

        return [
            'booking' => $this->statisticalBooking($from, $to),
            'revenue' => $this->statisticalRevenue($from, $to),
            'user' => $this->statisticalCustomer($from, $to),
        ];
    }

    /**
     * Thống kê lượng đơn đặt
     * @param Carbon $from
     * @param Carbon $to
     * @return Collection
     */
    public function statisticalBooking(Carbon $from, Carbon $to): Collection
    {
        $bookings = Booking::whereBetween('created_at', [$from, $to])->get();

        return collect([
            'total' => $this->formatNumber($bookings->count()),
            'on_web' => $bookings->where('type', BookingType::OnWebSite)->count(),
            'awaiting' => $bookings->whereIn('status', BookingStatus::getAwaitingBooking())->count(),
            'confirmed' => $bookings->whereIn('status', [BookingStatus::Confirmed['key'], BookingStatus::Approved['key']])->count(),
            'completed' => $bookings->where('status', BookingStatus::Completed['key'])->count(),
            'canceled' => $bookings->whereIn('status', BookingStatus::getDeActiveBooking())->count(),
        ]);
    }

    /**
     * Thống kê doanh thu
     * @param Carbon $from
     * @param Carbon $to
     * @return Collection
     */
    public function statisticalRevenue(Carbon $from, Carbon $to): Collection
    {
        $bookings = Booking::with('bookingRooms')
            ->whereIn('status', BookingStatus::getConfirmedBooking())
            ->whereBetween('created_at', [$from, $to])
            ->get();

        $price = $bookings->sum(function ($booking) {
            return $booking->bookingRooms()->sum('price');
        });
       $earlyFee = $bookings->sum(function ($booking) {
           return $booking->bookingRooms()->sum('early_fee');
       });
       $latelyFee = $bookings->sum(function ($booking) {
           return $booking->bookingRooms()->sum('lately_fee');
       });


       return collect([
           'total' => $this->formatNumber($price + $earlyFee + $latelyFee),
           'revenue' => $price + $earlyFee + $latelyFee,
           'price' => $price,
           'early_fee' => $earlyFee,
           'lately_fee' => $latelyFee,
       ]);
    }

    /**
     * Thống kê lượng khách
     * @param Carbon $from
     * @param Carbon $to
     * @return Collection
     */
    public function statisticalCustomer(Carbon $from, Carbon $to): Collection
    {
        $users = User::whereBetween('created_at', [$from, $to])->get();
        $usersHasBooked = $users->filter(function ($user) {
            return $user->bookings->isNotEmpty();
        });
        $adultCustomers = Booking::whereIn('status', BookingStatus::getConfirmedBooking())
            ->whereBetween('created_at', [$from, $to])
            ->sum('number_of_adults');
        $childrenCustomers = Booking::whereIn('status', BookingStatus::getConfirmedBooking())
            ->whereBetween('created_at', [$from, $to])
            ->sum('number_of_children');

        return collect(
            [
                'total' => $users->count(),
                'users_verified' => $users->whereNotNull('verified_at')->count(),
                'users_has_booked' => $usersHasBooked->count(),
                'adults_customers' => $adultCustomers,
                'children_customers' => $childrenCustomers,
            ]
        );
    }

    /**
     * Format lại số thoe kí tự viết tắt
     * @param $number
     * @return string
     */
    protected function formatNumber($number): string
    {
        $suffixes = array('', 'K', 'M', 'B', 'T');
        $index = 0;
        while (abs($number) >= 1000 && $index < (count($suffixes) - 1)) {
            $number /= 1000;
            $index++;
        }
        return round($number, 2) . $suffixes[$index];
    }
}
