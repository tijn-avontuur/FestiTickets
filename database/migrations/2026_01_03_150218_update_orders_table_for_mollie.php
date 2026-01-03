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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');

            $table->foreignId('event_id')->after('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->after('event_id');
            $table->decimal('ticket_price', 10, 2)->after('quantity');
            $table->decimal('service_fee', 10, 2)->after('ticket_price');
            $table->string('order_number')->unique()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_id')->constrained();
            $table->dropForeign(['event_id']);
            $table->dropColumn(['event_id', 'quantity', 'ticket_price', 'service_fee', 'order_number']);
        });
    }
};
