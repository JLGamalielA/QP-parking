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
        Schema::create('special_parking_roles', function (Blueprint $table) {
            $table->id('special_parking_role_id');

            $table->foreignId('parking_id')
                ->constrained('parkings', 'parking_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->string('type', 50);
            $table->integer('special_commission_period');
            $table->decimal('special_commission_value', 7, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_parking_roles');
    }
};
