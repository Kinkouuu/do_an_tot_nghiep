<?php

namespace App\Console\Commands;

use App\Enums\Booking\BookingStatus;
use App\Events\BookingChangeStatus;
use App\Services\Admin\BookingService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AutoCancelBookingWhenNotPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:auto-cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto cancel booking when user not completed payment by VNPay';
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        parent::__construct();
        $this->bookingService = $bookingService;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $awaitingBookings = $this->bookingService->getByStatusAndCreatedAtBefore(BookingStatus::AwaitingPayment['key'], Carbon::now()->subMinutes(15));
        foreach ($awaitingBookings as $awaitingBooking)
        {
                $roomInfo = Cache::get('booking_' . $awaitingBooking->id);
                $awaitingBooking->status = BookingStatus::Refuse['key'];
                $awaitingBooking->refuse_reason = 'Tự động hủy do chưa hoàn thành thanh toán';
                $awaitingBooking->save();
                Log::info('Auto cancel booking '. $awaitingBooking->id . ' because not payment success');
                BookingChangeStatus::dispatch($awaitingBooking->user, $awaitingBooking, $roomInfo);
                Cache::forget('booking_' . $awaitingBooking->id);
        }
        return 'Auto cancel bookings not complete payment 15min before';
    }
}
