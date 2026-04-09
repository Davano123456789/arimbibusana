<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'snap_token',
        'customer_name',
        'customer_phone',
        'customer_address',
        'province_id',
        'province_name',
        'city_id',
        'city_name',
        'district_id',
        'district_name',
        'shipping_cost',
        'shipping_etd',
        'courier',
        'customer_postal_code',
        'total_price',
        'status',
        'notes',
        'tracking_number',
        'shipped_at',
        'cancel_reason',
        'refund_bank',
        'refund_account_number',
        'refund_receipt',
        'expired_at',
    ];
    
    protected $casts = [
        'expired_at' => 'datetime',
        'shipped_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
