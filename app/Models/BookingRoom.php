<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    use HasFactory;

    protected $table = 'booking_room';
    protected $fillable = [
      'booking_id',
      'room_id',
      'checkin_at',
      'checkout_at',
      'price',
    ];
}
