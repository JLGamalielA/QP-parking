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
        Schema::create('parking_entries', function (Blueprint $table) {
            $table->id('parking_entry_id');

            $table->foreignId('parking_id')
                ->constrained('parkings', 'parking_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->string('name', 50);
            $table->boolean('is_entry');
            $table->boolean('is_active')->default(false);

            $table->timestamps();

            $table->unique(['parking_id', 'name'], 'idx_parking_entries_parking_id_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_entries');
    }
};
