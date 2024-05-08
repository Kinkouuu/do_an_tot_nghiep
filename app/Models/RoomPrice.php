<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_room_id',
        'type_price',
        'price'
    ];

    public function roomType()
    {
        return $this->belongsTo(TypeRoom::class);
    }
}
