<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'paid',
        'note',
        'reason',
        'creator',
        'cashier',
    ];

    public function bookingRooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id')
            ->withPivot('checkin_at', 'checkout_at', 'early_fee', 'lately_fee', 'price');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Nhân viên tạo đơn
     * @return BelongsTo
     */
    public function bookingCreator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'creator', 'id');
    }

    /**
     * Nhân viên thu ngân
     * @return BelongsTo
     */
    public function bookingCashier(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'cashier', 'id');
    }

    public function feedBack(): HasMany
    {
        return $this->hasMany(FeedBack::class);
    }
    public static function getColumnsFilter(): array
    {
        return [
            'branch_name',
            'booking_id',
            'name',
            'phone',
            'citizen_id',

        ];
    }
}
