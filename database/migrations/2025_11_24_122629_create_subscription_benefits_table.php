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
        Schema::create('subscription_benefits', function (Blueprint $table) {
            $table->id('subscription_benefit_id');
            $table->foreignId('subscription_id')
                ->constrained('subscriptions', 'subscription_id')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
            $table->string('benefit', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_benefits');
    }
};
