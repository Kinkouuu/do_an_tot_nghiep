<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'account_name',
        'password',
        'status',
        'role',
        'home_town',
        'email',
        'phone',
        'citizen_id',
        'gender',
    ];

    public static function getColumnsFilter(): array
    {
        return [
            'name',
            'account_name',
            'role',
            'email',
            'phone',
            'citizen_id',
        ];
    }
}
