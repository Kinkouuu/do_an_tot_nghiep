<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingChangeStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Booking $booking;
    public array $roomInfo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, array $roomInfo)
    {
        $this->booking = $booking;
        $this->roomInfo = $roomInfo;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
