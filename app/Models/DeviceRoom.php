<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceRoom extends Model
{
    use HasFactory;

    protected $table = 'device_room';

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
