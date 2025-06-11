<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'userId',
        'name',
        'type',
        'baju',
        'celana',
        'jaket',
        'gaun',
        'sprey_kasur',
        'weight',
        'delivery_option',
        'service_type',
        'description',
        'total',
        'midtrans_order_id',
        'latitude',
        'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

}