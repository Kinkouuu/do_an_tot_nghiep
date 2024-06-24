<?php

namespace App\Console\Commands;

use App\Enums\Booking\BookingStatus;
use App\Services\Admin\BookingService;
use Illuminate\Console\Command;

class AutoApproveBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:auto-approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto approve awaiting confirm booking after one hour from created';

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
        $awaitingBookings = $this->bookingService->getAwaitingBookingOneHourBefore();
        foreach ($awaitingBookings as $awaitingBooking) {
            $awaitingBooking->status = BookingStatus::Approved['key'];
            $awaitingBooking->save();
            \Log::info('Auto approve booking ' . $awaitingBooking->id . 'after one hour from created');
        }
        return true;
    }
}
