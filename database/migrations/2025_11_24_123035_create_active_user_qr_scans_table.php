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
        Schema::create('active_user_qr_scans', function (Blueprint $table) {
            $table->id('active_user_qr_scan_id');

            $table->foreignId('parking_entry_id')
                ->constrained('parking_entries', 'parking_entry_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->dateTime('scan_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_user_qr_scans');
    }
};
