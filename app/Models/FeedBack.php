<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedBack extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'admin_id',
        'room_type_id',
        'rate_stars',
        'comment',
        'reply',
        'reply_at',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(TypeRoom::class);
    }
}
