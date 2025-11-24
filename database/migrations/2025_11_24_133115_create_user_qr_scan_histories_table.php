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
        Schema::create('user_qr_scan_histories', function (Blueprint $table) {
            $table->id('user_qr_scan_history_id');

            $table->unsignedBigInteger('parking_entry');
            $table->unsignedBigInteger('parking_exit');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->dateTime('first_scan_time');
            $table->dateTime('last_scan_time');

            $table->integer('stay_duration_seconds');

            $table->foreignId('parking_transaction_id')
                ->constrained('parking_transactions', 'parking_transaction_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_qr_scan_histories');
    }
};
