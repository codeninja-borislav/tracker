<?php

use App\Enums\CurrencyPair;
use App\Enums\NotificationType;
use App\Enums\TimeInterval;
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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum('currency_pair', array_map(fn($case) => $case->value, CurrencyPair::cases()));
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index('currency_pair');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
