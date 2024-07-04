<?php

namespace App\Listeners;

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\PaymentType;
use App\Events\BookingChangeStatus;
use App\Events\BookingEvent;
use App\Mail\SendBookingCompletedMail;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendBookingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookingEvent  $event
     * @return void
     */
    public function handle(BookingEvent|BookingChangeStatus $event)
    {
        $email = Auth::user()->email ?? $event->user;
        $booking = $event->booking;
        $roomInfo = $event->roomInfo;
        if($booking->status == BookingStatus::AwaitingPayment['key'])
        {
            return;
        }
        $title = match ($booking->status) {
            BookingStatus::AwaitingConfirm['key'] => config('constants.title_booking_notification.awaiting_confirm'),
            BookingStatus::Approved['key'] => config('constants.title_booking_notification.approved'),
            BookingStatus::Refuse['key'] => config('constants.title_booking_notification.refuse') . $booking->refuse_reason,
        };
        if($booking->status == BookingStatus::Refuse['key']) {
            $message = [
                '<p>Vui lòng chờ ít phút, chúng tôi sẽ gọi điện tư vấn cho bạn hoặc bạn có thể đặt lại đơn khác theo ' .
                '<a style="color: blue" href=\''. route("search", $roomInfo["condition"]) .'\'>đường dẫn.</a></p>',
                '<p >Số tiền đã thanh toán trước (nếu có) của đơn hàng sẽ được hoàn trả sau 24h làm việc.</p>'
            ];
        } else {
            $message = [
                '<p>Lưu ý: Người đại diện nhận phòng cần mang theo thẻ căn cước, chứng minh thư, hộ chiếu... hoặc các giấy tờ tùy thân tương đương để làm thủ tục nhận phòng.</p>',
                '<p>Nếu có bất kì thắc mắc cần được tư vấn, vui lòng liên hệ qua số hotline: ' . $roomInfo["branch"]["phone"] . '</p>',
            ];
            if ($booking->for_relative)
            {
                $message[] = '<p> Chúng tôi cũng sẽ gọi điện cho anh/chị ' . $booking->name . ' qua số điện thoại ' . $booking->phone . ' để xác nhận lại đơn hàng. </p>';
            }
        }
        $paymentType = match ($booking->payment_type) {
          PaymentType::Cash => 'Tiền mặt',
          PaymentType::VNPay => 'Ví VNPay' ,
          PaymentType::DebitCard => 'Thẻ Visa Debit' ,
        };
        $data = [
            'title' => $title,
            'messages' => $message,
            'booking' => [
                'id' => base64_encode($booking->id),
                'created_at' => $booking->created_at->isoFormat('dddd, HH:mm DD/MM/YYYY'),
                'payment_type' => $paymentType,
                'booking_checkin' => Carbon::parse($booking->booking_checkin)->isoFormat('dddd, HH:mm DD/MM/YYYY'),
                'booking_checkout' => Carbon::parse($booking->booking_checkout)->isoFormat('dddd, HH:mm DD/MM/YYYY'),
                'adults' => $booking->number_of_adults,
                'children' => $booking->number_of_children,
                'deposit' => $booking->deposit,
            ],
            'branch' => [
                'name' => $roomInfo['branch']['name'],
                'phone' => $roomInfo['branch']['phone'],
                'address' => $roomInfo['branch']['address'],
                'city' => $roomInfo['branch']['city'],
            ],
            'rooms' => $roomInfo['rooms'],
            'total_amount' => $roomInfo['total_amount']
        ];
        Mail::to($email)->send(new SendBookingCompletedMail($data));
    }
}
