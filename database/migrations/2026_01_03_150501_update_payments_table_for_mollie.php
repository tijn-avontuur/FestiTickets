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
        Schema::table('payments', function (Blueprint $table) {
            // Rename payment_reference to mollie_payment_id
            $table->renameColumn('payment_reference', 'mollie_payment_id');

            // Add new columns
            $table->foreignId('order_id')->after('id')->constrained()->onDelete('cascade');
            $table->string('currency', 3)->default('EUR')->after('amount');
            $table->string('method')->nullable()->after('currency');
            $table->timestamp('paid_at')->nullable()->after('method');

            // Provider column is no longer needed (it's always Mollie)
            $table->dropColumn('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('mollie_payment_id', 'payment_reference');
            $table->string('provider')->after('id');
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'currency', 'method', 'paid_at']);
        });
    }
};
