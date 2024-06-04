<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'country',
        'gender',
        'citizen_id',
        'for_relative',
        'payment_type',
        'type',
        'booking_checkin',
        'booking_checkout',
        'status',
        'number_of_adults',
        'number_of_children',
        'deposit',
        'note',
        'reason',
    ];

    public function bookingRooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id')
            ->withPivot('checkin_at', 'checkout_at', 'price');
    }
}
