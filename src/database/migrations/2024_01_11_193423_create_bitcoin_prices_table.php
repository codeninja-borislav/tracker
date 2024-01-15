<?php

use App\Enums\CurrencyPair;
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
        Schema::create('bitcoin_prices', function (Blueprint $table) {
            $table->id();
            $table->enum('currency_pair', array_map(fn($case) => $case->value, CurrencyPair::class::cases()));
            $table->decimal('price', 15, 2);
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitcoin_prices');
    }
};
