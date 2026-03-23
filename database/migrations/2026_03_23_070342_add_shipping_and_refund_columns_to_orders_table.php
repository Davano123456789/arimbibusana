<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('status');
            $table->timestamp('shipped_at')->nullable()->after('tracking_number');
            $table->text('cancel_reason')->nullable()->after('shipped_at');
            $table->string('refund_bank')->nullable()->after('cancel_reason');
            $table->string('refund_account_number')->nullable()->after('refund_bank');
            $table->string('refund_receipt')->nullable()->after('refund_account_number');
        });

        // Use raw SQL to alter ENUM in MySQL
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('unpaid', 'settlement', 'pending', 'expire', 'cancel', 'shipped', 'completed', 'waiting_refund', 'refunded') DEFAULT 'unpaid'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('unpaid', 'settlement', 'pending', 'expire', 'cancel') DEFAULT 'unpaid'");
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'shipped_at', 'cancel_reason', 'refund_bank', 'refund_account_number', 'refund_receipt']);
        });
    }
};
