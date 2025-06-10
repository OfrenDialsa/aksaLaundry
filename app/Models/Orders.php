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
        'total',
        'midtrans_order_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

}