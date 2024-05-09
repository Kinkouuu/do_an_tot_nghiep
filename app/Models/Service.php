<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type_service_id',
        'name',
        'description',
        'status',
        'price',
    ];

    public function typeService(): BelongsTo
    {
        return $this->belongsTo(TypeService::class);
    }

    public static function getColumnsFilter(): array
    {
        return [
            'name',
            'price',
            'status'
        ];
    }

    /**
     * Get room type have services
     * @return BelongsToMany
     */
    public function roomTypes(): BelongsToMany
    {
        return $this->belongsToMany(TypeRoom::class, 'room_type_service', 'room_type_id', 'service_id');
    }
}
