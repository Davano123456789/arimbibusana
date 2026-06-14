<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PointTransaction;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoyaltyPointsTest extends TestCase
{
    use DatabaseTransactions;

    protected $category;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear settings and establish defaults
        Setting::whereIn('key', [
            'loyalty_status',
            'loyalty_min_order',
            'loyalty_points_given',
            'loyalty_method',
            'loyalty_point_value'
        ])->delete();

        Setting::create(['key' => 'loyalty_status', 'value' => '1']);
        Setting::create(['key' => 'loyalty_min_order', 'value' => '1000000']);
        Setting::create(['key' => 'loyalty_points_given', 'value' => '100']);
        Setting::create(['key' => 'loyalty_method', 'value' => 'flat']);
        Setting::create(['key' => 'loyalty_point_value', 'value' => '100']);

        // Create dummy category and product
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category-' . uniqid()
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product-' . uniqid(),
            'price' => 100000,
            'stock' => 10,
            'status' => 'active'
        ]);
    }

    public function test_award_points_flat_method()
    {
        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'points' => 0
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'AQ-TEST-' . uniqid(),
            'customer_name' => $user->name,
            'customer_phone' => '0812345678',
            'customer_address' => 'Test Address',
            'total_price' => 1050000,
            'status' => 'settlement'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'size_name' => 'M',
            'quantity' => 1,
            'price' => 1050000
        ]);

        $order->awardPoints();

        $user->refresh();
        $order->refresh();

        $this->assertEquals(100, $user->points);
        $this->assertEquals(100, $order->points_earned);
        
        $transaction = PointTransaction::where('order_id', $order->id)->where('type', 'earn')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(100, $transaction->amount);
    }

    public function test_award_points_multiplier_method()
    {
        Setting::where('key', 'loyalty_method')->update(['value' => 'multiplier']);

        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'points' => 0
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'AQ-TEST-' . uniqid(),
            'customer_name' => $user->name,
            'customer_phone' => '0812345678',
            'customer_address' => 'Test Address',
            'total_price' => 2500000,
            'status' => 'settlement'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'size_name' => 'M',
            'quantity' => 1,
            'price' => 2500000
        ]);

        $order->awardPoints();

        $user->refresh();
        $order->refresh();

        // 2,500,000 / 1,000,000 = 2.5 => floor(2.5) = 2. 2 * 100 = 200 points
        $this->assertEquals(200, $user->points);
        $this->assertEquals(200, $order->points_earned);
    }

    public function test_refund_points()
    {
        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'points' => 50
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'AQ-TEST-' . uniqid(),
            'customer_name' => $user->name,
            'customer_phone' => '0812345678',
            'customer_address' => 'Test Address',
            'points_used' => 150,
            'points_discount' => 15000,
            'total_price' => 500000,
            'status' => 'cancel'
        ]);

        $order->refundPoints();

        $user->refresh();
        $this->assertEquals(200, $user->points); // 50 + 150

        $transaction = PointTransaction::where('order_id', $order->id)->where('type', 'refund')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(150, $transaction->amount);
    }

    public function test_revoke_points()
    {
        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'points' => 150
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'AQ-TEST-' . uniqid(),
            'customer_name' => $user->name,
            'customer_phone' => '0812345678',
            'customer_address' => 'Test Address',
            'points_earned' => 100,
            'total_price' => 1050000,
            'status' => 'refunded'
        ]);

        $order->revokePoints();

        $user->refresh();
        $this->assertEquals(50, $user->points); // 150 - 100

        $transaction = PointTransaction::where('order_id', $order->id)->where('type', 'revoke')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(-100, $transaction->amount);
    }
}
