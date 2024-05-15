<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
      'room_type_id',
      'branch_id',
      'name',
      'description',
      'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function roomType()
    {
        return $this->belongsTo(TypeRoom::class);
    }

    /**
     * Get room type's services
     * @return BelongsToMany
     */
    public function roomDevices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'device_room', 'room_id', 'device_id')
            ->withPivot('quantity', 'note');
    }

    public static function getColumnsFilter()
    {
        return [
            'id',
            'name',
            'room_type',
            'branch',
            'city',
            'status',
        ];
    }
}
