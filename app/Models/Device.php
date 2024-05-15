<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    protected  $fillable = [
        'type_device_id',
        'name',
        'rental_price',
        'quantity',
        'brand',
        'description',
        'for_rent',
    ];

    public function typeDevice(): BelongsTo
    {
        return $this->belongsTo(TypeDevice::class);
    }

    public static function getColumnsFilter(): array
    {
        return [
            'name',
            'rental_price',
            'brand',
            'type_device',
        ];
    }
}
