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
        Schema::create('parking_schedules', function (Blueprint $table) {
            $table->id('parking_schedule_id');

            $table->foreignId('parking_id')
                ->constrained('parkings', 'parking_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->unsignedTinyInteger('weekday');

            $table->boolean('is_open')->default(true);

            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();

            $table->unique(['parking_id', 'weekday'], 'uniq_parking_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_schedules');
    }
};
