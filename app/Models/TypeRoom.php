<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeRoom extends Model
{
    use HasFactory;

    protected $table = 'room_types';
    protected $fillable = [
      'name',
      'description',
      'status',
    ];

    /**
     * Get listed room type's prices
     * @return HasMany
     */
    public function roomPrices(): HasMany
    {
        return $this->hasMany(RoomPrice::class);
    }

    /**
     * Get room type's image
     * @return HasMany
     */
    public function roomImages(): HasMany
    {
        return $this->hasMany(RoomImage::class);
    }

    /**
     * Get room type's services
    * @return BelongsToMany
     */
    public function roomServices(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'room_type_service', 'room_type_id', 'service_id')->withPivot('discount');
    }
}
