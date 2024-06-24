<?php

namespace App\Services\User;

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
use App\Enums\Booking\PaymentType;
use App\Enums\Room\PriceType;
use App\Events\BookingEvent;
use App\Jobs\AutoCancelBooking;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BookingService extends BaseService
{
    public function getModel()
    {
        return Booking::class;
    }

    /**
     * Xử lý thêm đơn đặt phòng
     * @param User $user
     * @param array $customerInfo
     * @param array $roomInfo
     * @return array
     */
    public function storeBooking(User $user, array $customerInfo, array $roomInfo): array
    {
        $status = $customerInfo['payment'] == PaymentType::Cash
            ? $this->hasCompletedBookingOrVerified($user)
                ? BookingStatus::Approved['key']
                : BookingStatus::AwaitingConfirm['key']
            : BookingStatus::AwaitingPayment['key'];
        $bookingData = [
            'user_id' => $user->id,
            'name' => $customerInfo['name'],
            'phone' => $customerInfo['phone'],
            'country' => $customerInfo['country'],
            'gender' => $customerInfo['gender'],
            'citizen_id' => $customerInfo['citizen_id'],
            'note' => $customerInfo['note'],
            'for_relative' => isset($customerInfo['forRelative']),
            'type' => BookingType::OnWebSite,
            'status' => $status,
            'deposit' => 0,
            'payment_type' => $customerInfo['payment'],
            'booking_checkin' => Carbon::parse($roomInfo['condition']['checkin']),
            'booking_checkout' => Carbon::parse($roomInfo['condition']['checkout']),
            'number_of_adults' => $roomInfo['condition']['adults'],
            'number_of_children' => $roomInfo['condition']['children'],
        ];
        //Lưu thông tin đơn đặt
        $booking = $this->create($bookingData);
        Cache::forget('cart_' . $user->id);
        BookingEvent::dispatch($booking, $roomInfo);

        if ($customerInfo['payment'] == PaymentType::VNPay || $customerInfo['payment'] == PaymentType::DebitCard) {
            AutoCancelBooking::dispatch($booking, $roomInfo)->delay(now()->addMinutes(15));

            //chuyển hướng sang trang thanh toán vnpay
            $this->vnPay($booking, $roomInfo);
        }

        return $this->successResponse(
            'Đặt phòng thành công!',
            null,
            'booking.list');
    }

    /**
     * @param $condition
     * @return array
     */
    public function retrieveCondition($condition): array
    {
        $checkIn = Carbon::parse($condition['checkin']);
        $checkout = Carbon::parse($condition['checkout']);
        $duration = $this->calculateTripDuration($checkIn, $checkout);

        return [
            'checkin' => $checkIn,
            'checkout' => $checkout,
            'duration' => $duration,
            'adults' => $condition['adults'],
            'children' => $condition['children']
        ];
    }

    public function vnPay(Booking $booking, array $roomInfo)
    {
        Cache::put('booking_' . $booking->id, $roomInfo, 15);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('booking.payment-response', base64_encode($booking->id));
        $vnp_TmnCode = "Z8LH3ZFU";//Mã website tại VNPAY
        $vnp_HashSecret = "9HS6QBRILFD1SFL4J4JBRTZ7BPMPTRG6"; //Chuỗi bí mật

        $vnp_TxnRef = $booking->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $booking->name . ' thanh toán đặt phòng tại V.V.C Booking';
        $vnp_OrderType = 'Thanh toán VNPay';
        $vnp_Amount = $roomInfo['total_amount']['total_price'] * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = $booking->payment_type;
//        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    /** Kiểm tra người dùng đã có đơn đặt được xác nhận|thành công hoặc đã được xác minh tài khoản
     * @param User $user
     * @return bool
     */
    private function hasCompletedBookingOrVerified(User $user): bool
    {
        $completedBooking = Booking::where('user_id', $user->id)->whereIn('status',BookingStatus::getConfirmedBooking())->first();
        return !!$completedBooking || !!$user->verified_at;
    }

    /**
     * Kiểm tra phòng đã được đặt trước trong khoảng thời gian đó chưa
     * @param int $roomId
     * @param Carbon $checkIn
     * @param Carbon $checkOut
     * @return Collection
     */
    public function roomHasBooked(int $roomId, Carbon $checkIn, Carbon $checkOut): Collection
    {
        return DB::table('bookings')
            ->leftJoin('booking_room','bookings.id', '=', 'booking_room.booking_id')
            ->where('booking_room.room_id', $roomId)
            ->where('bookings.booking_checkin', '<', $checkOut)
            ->where('bookings.booking_checkout', '>', $checkIn)
            ->whereNotIn('bookings.status', BookingStatus::getDeActiveBooking())
            ->get();
    }
    public function getBookingOrders(User $user): \Illuminate\Database\Eloquent\Collection|array
    {
        return Booking::with('bookingRooms')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Người dùng hủy đơn đặt phòng
     * @param Booking $booking
     * @return array
     */
    public function cancel(Booking $booking): array
    {
        $booking->status = BookingStatus::Canceled['key'];
        $booking->save();
        return $this->successResponse('Hủy đơn đặt phòng thành công!');
    }

    /**
     * Convert thời gian đặt phòng thành ngày và đêm
     * @param Carbon $checkIn
     * @param Carbon $checkOut
     * @return string
     */
    protected function calculateTripDuration(Carbon $checkIn, Carbon $checkOut): string
    {
        $time = $checkOut->diffInHours($checkIn);
        // Làm tròn thêm 1 tiếng nếu dưới 24 giờ
        if ($time < 24) {
            $duration = ceil($time / 1) . ' giờ';
        }
        // Làm tròn lên 1 ngày nếu trên 24 giờ
        else {
            $days = ceil($time / 24);
            $nights = ($days > 1) ? $days - 1 : $days;
            $duration = $days . ' ngày ' . $nights . ' đêm';
        }

        return $duration;
    }

    /**
     * Tính phí check in sớm và check out muộn
     * @param Room $room
     * @param Carbon $checkIn
     * @param Carbon $checkOut
     * @return array[]
     */
    public function calculateEarlyOrLateFee(Room $room, Booking $booking): array
    {
        //Tính thời gian sớm/muộn (đơn vị giờ)
        $earlyTime = (strtotime($booking->booking_checkin) - strtotime($room->pivot->checkin_at)) / config('constants.convert_time.hour');
        $earlyFee = $booking->bookingRooms()->where('room_id', $room->id)->first()->pivot->early_fee;
        if (is_null($earlyFee))
        {
            $earlyPrice = $room->roomType->roomPrices->where('type_price', PriceType::EarlyCheckIn['value'])->first()->price;
            $earlyFee = $earlyTime > 0 ? round($earlyTime) * $earlyPrice : 0;
            $booking->bookingRooms()->updateExistingPivot($room->id, [
                'early_fee' => $earlyFee,
                'updated_at' => Carbon::now()
            ]);
        }

        $latelyTime = (strtotime($room->pivot->checkout_at) - strtotime($booking->booking_checkout)) / config('constants.convert_time.hour');
        $latelyFee = $booking->bookingRooms()->where('room_id', $room->id)->first()->pivot->lately_fee;
        if (is_null($latelyFee)) {
            $latelyPrice = $room->roomType->roomPrices->where('type_price', PriceType::LateCheckOut['value'])->first()->price;
            $latelyFee = $latelyTime > 0 ? round($latelyTime) * $latelyPrice : 0;
            $booking->bookingRooms()->updateExistingPivot($room->id, [
                'lately_fee' => $latelyFee,
                'updated_at' => Carbon::now()
            ]);
        }
        return [
            'early_time' => round($earlyTime, 1),
            'early_fee' => $earlyFee,
            'lately_time' => round($latelyTime,1),
            'lately_fee' => $latelyFee,
        ];
    }

    /**
     * In thông tin hóa đơn
     * @param Booking $booking
     * @return array
     */
    public function getBookingInvoice(Booking $booking): array
    {
        $bookingCheckIn = Carbon::parse($booking->booking_checkin);
        $bookingCheckOut = Carbon::parse($booking->booking_checkout);
        $duration = $this->calculateTripDuration($bookingCheckIn, $bookingCheckOut);
        $rooms = [];
        foreach ($booking->bookingRooms as $bookingRoom) {
            $fee = $this->calculateEarlyOrLateFee($bookingRoom, $booking);
            $room = array_merge($fee, [
                'room_id' => $bookingRoom->id,
                'room_name' => $bookingRoom->name,
                'room_type_id' => $bookingRoom->roomType->id,
                'room_type' => $bookingRoom->roomType->name,
                'price' => $bookingRoom->pivot->price,
                'checkin_at' => $bookingRoom->pivot->checkin_at,
                'checkout_at' => $bookingRoom->pivot->checkout_at,
            ]);
            $rooms[] = $room;
        }
        $totalFee = array_sum(array_column($rooms, 'early_fee')) + array_sum(array_column($rooms, 'lately_fee'));
        $totalPrice = array_sum(array_column($rooms, 'price'));
        return [
            'branch' => $booking->bookingRooms->first()->branch,
            'booking' => $booking,
            'rooms' => collect($rooms)->sortBy('room_name'),
            'total' =>[
                'total_time' => $duration,
                'total_price' => $totalPrice,
                'total_fee' => $totalFee,
                'total_room' => count($rooms),
                'total_cost' => $totalPrice + $totalFee,
                'total_refund' => max($booking['deposit'] + $booking['paid'] - $totalPrice - $totalFee, 0),
            ],
        ];
    }
}
