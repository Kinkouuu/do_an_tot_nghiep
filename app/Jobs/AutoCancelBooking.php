<?php

namespace App\Jobs;

use App\Enums\Booking\BookingStatus;
use App\Events\BookingChangeStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoCancelBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Booking $booking;
    protected array $roomInfo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, array $roomInfo)
    {
        $this->booking = $booking;
        $this->roomInfo = $roomInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (
            $this->booking->status == BookingStatus::AwaitingPayment['key']
        ) {
            $this->booking->status = BookingStatus::Refuse['key'];
            $this->booking->refuse_reason = 'Tự động hủy do chưa hoàn thành thanh toán';
            $this->booking->save();
            Log::info('Auto cancel booking '. $this->booking->id . ' because not payment success');
            BookingChangeStatus::dispatch($this->booking, $this->roomInfo);
        } else {
            Log::info('User completed payment booking ' . $this->booking->id);
        }
    }
}
