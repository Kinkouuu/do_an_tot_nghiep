<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'country',
        'gender',
        'citizen_id',
        'birth_day',
        'created_by',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
