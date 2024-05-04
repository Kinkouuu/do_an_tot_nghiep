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
        'price',
    ];

    public function typeService()
    {
        return $this->belongsTo('type_services', 'type_service_id');
    }
}
