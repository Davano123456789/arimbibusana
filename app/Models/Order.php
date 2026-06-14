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
        'points_earned',
        'points_used',
        'points_discount',
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

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Award loyalty points for this order.
     */
    public function awardPoints()
    {
        $loyaltyStatus = \App\Models\Setting::getValue('loyalty_status', '0');
        if ($loyaltyStatus !== '1') {
            return;
        }

        // Prevent double award
        $alreadyAwarded = \App\Models\PointTransaction::where('order_id', $this->id)
            ->where('type', 'earn')
            ->exists();

        if ($alreadyAwarded) {
            return;
        }

        // Calculate subtotal from order items
        $subtotal = $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $minOrder = (int)\App\Models\Setting::getValue('loyalty_min_order', '1000000');
        $pointsGiven = (int)\App\Models\Setting::getValue('loyalty_points_given', '100');
        $method = \App\Models\Setting::getValue('loyalty_method', 'flat');

        if ($minOrder > 0 && $subtotal >= $minOrder) {
            $pointsEarned = 0;
            if ($method === 'multiplier') {
                $multiples = (int) floor($subtotal / $minOrder);
                $pointsEarned = $multiples * $pointsGiven;
            } else {
                $pointsEarned = $pointsGiven;
            }

            if ($pointsEarned > 0) {
                \Illuminate\Support\Facades\DB::transaction(function () use ($pointsEarned) {
                    $user = $this->user;
                    if ($user) {
                        $user->increment('points', $pointsEarned);
                        $this->update(['points_earned' => $pointsEarned]);

                        \App\Models\PointTransaction::create([
                            'user_id' => $user->id,
                            'order_id' => $this->id,
                            'type' => 'earn',
                            'amount' => $pointsEarned,
                            'description' => "Mendapatkan {$pointsEarned} poin dari pesanan #{$this->order_number}",
                        ]);
                    }
                });
            }
        }
    }

    /**
     * Refund the points used for discount on this order.
     */
    public function refundPoints()
    {
        if ($this->points_used > 0) {
            // Check if already refunded to prevent double refund
            $alreadyRefunded = \App\Models\PointTransaction::where('order_id', $this->id)
                ->where('type', 'refund')
                ->exists();

            if (!$alreadyRefunded) {
                \Illuminate\Support\Facades\DB::transaction(function () {
                    $user = $this->user;
                    if ($user) {
                        $user->increment('points', $this->points_used);
                        
                        \App\Models\PointTransaction::create([
                            'user_id' => $user->id,
                            'order_id' => $this->id,
                            'type' => 'refund',
                            'amount' => $this->points_used,
                            'description' => "Pengembalian {$this->points_used} poin dari pembatalan/refund pesanan #{$this->order_number}",
                        ]);
                    }
                });
            }
        }
    }

    /**
     * Revoke the points earned from this order.
     */
    public function revokePoints()
    {
        if ($this->points_earned > 0) {
            // Check if already revoked to prevent double revoke
            $alreadyRevoked = \App\Models\PointTransaction::where('order_id', $this->id)
                ->where('type', 'revoke')
                ->exists();

            if (!$alreadyRevoked) {
                \Illuminate\Support\Facades\DB::transaction(function () {
                    $user = $this->user;
                    if ($user) {
                        $newPoints = max(0, $user->points - $this->points_earned);
                        $user->update(['points' => $newPoints]);
                        
                        \App\Models\PointTransaction::create([
                            'user_id' => $user->id,
                            'order_id' => $this->id,
                            'type' => 'revoke',
                            'amount' => -$this->points_earned,
                            'description' => "Penarikan {$this->points_earned} poin dari refund/pembatalan pesanan #{$this->order_number}",
                        ]);
                    }
                });
            }
        }
    }
}
