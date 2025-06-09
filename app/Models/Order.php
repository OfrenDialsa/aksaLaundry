<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

}