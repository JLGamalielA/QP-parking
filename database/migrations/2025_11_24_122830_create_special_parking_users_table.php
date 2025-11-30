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
        Schema::create('special_parking_users', function (Blueprint $table) {
            $table->id('special_parking_user_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
                
            $table->foreignId('parking_id')
                ->constrained('parkings', 'parking_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
            $table->foreignId('special_parking_role_id')
                ->constrained('special_parking_roles', 'special_parking_role_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->dateTime('permission_start_date');
            $table->timestamps();
            $table->unique(['parking_id', 'user_id'], 'idx_unique_parking_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_parking_users');
    }
};
