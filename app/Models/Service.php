<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function typeService()
    {
        return $this->belongsTo(TypeService::class);
    }

    public static function getColumnsFilter()
    {
        return [
            'name',
            'price',
            'status'
        ];
    }
}
