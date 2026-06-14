<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('avatar');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('points_earned')->default(0)->after('total_price');
            $table->integer('points_used')->default(0)->after('points_earned');
            $table->decimal('points_discount', 12, 2)->default(0)->after('points_used');
        });

        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // earn, redeem, refund
            $table->integer('amount'); // positive/negative
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['points_earned', 'points_used', 'points_discount']);
        });
    }
};
