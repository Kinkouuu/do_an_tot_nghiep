<?php

namespace App\Services\User;

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
use App\Enums\Booking\PaymentType;
use App\Events\BookingEvent;
use App\Models\Booking;
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
        $time = $checkout->diffInHours($checkIn);
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

        return [
            'checkin' => $checkIn,
            'checkout' => $checkout,
            'duration' => $duration,
            'adults' => $condition['adults'],
            'children' => $condition['children']
        ];
    }

    protected function vnPay(Booking $booking, array $roomInfo)
    {
        Cache::put('booking_' . $booking->id, $roomInfo);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('booking.payment-response', base64_encode($booking->id));
        $vnp_TmnCode = "Z8LH3ZFU";//Mã website tại VNPAY
        $vnp_HashSecret = "9HS6QBRILFD1SFL4J4JBRTZ7BPMPTRG6"; //Chuỗi bí mật

        $vnp_TxnRef = $booking->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $booking->name . ' thanh toán đặt phòng tại V.V.CBooking';
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
}
