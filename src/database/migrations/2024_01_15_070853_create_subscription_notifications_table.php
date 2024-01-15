<?php

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
        Schema::create('subscription_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
            $table->enum('notification_type', array_map(fn($case) => $case->value, NotificationType::cases()));
            $table->decimal('threshold_value', 15, 2)->nullable();
            $table->enum('time_interval', array_map(fn($case) => $case->value, TimeInterval::cases()))->nullable();
            $table->boolean('triggered')->default(false);
            $table->timestamp('triggered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_notifications');
    }
};
