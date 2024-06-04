<?php

namespace App\Listeners;

use App\Events\BookingEvent;
use App\Mail\SendBookingCompletedMail;
use Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
    public function handle(BookingEvent $event)
    {
        $user = Auth::user();
        $booking = $event->booking;
        $roomInfo = $event->roomInfo;

        $bookingInfo = [
            'id' => base64_encode($booking->id),
            'name' => $booking->name,
            'phone' => $booking->phone,
            'for_relative' => $booking->for_relative,
            'payment_type' => $booking->payment_type,
            'booking_checkin' => $booking->booking_checkin,
            'booking_checkout' => $booking->booking_checkout,
            'status' => $booking->status,
            'adult' => $booking->number_of_adult,
            'children' => $booking->number_of_children,
            'deposit' => $booking->deposit,
            'note' => $booking->note,
            'refuse_reason' => $booking->refuse_reason,
            'created_at' => $booking->created_at
        ];
        Mail::to($user)->send(new SendBookingCompletedMail($user->name, $bookingInfo, $roomInfo));
    }
}
