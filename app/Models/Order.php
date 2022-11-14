<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatusEnum;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'pickup_address', 'delivery_address', 'delivery_user_id',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class
    ];
}
