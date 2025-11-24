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
        Schema::create('special_user_parking_requests', function (Blueprint $table) {
            $table->id('special_user_parking_request_id');
            $table->foreignId('parking_id')
                ->constrained('parkings', 'parking_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('special_parking_role_id')
                ->constrained('special_parking_roles', 'special_parking_role_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->unique(['parking_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_user_parking_requests');
    }
};
