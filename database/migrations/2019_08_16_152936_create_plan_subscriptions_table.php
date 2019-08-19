<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plan_subscriptions', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('team_id');
            $table->uuid('plan_id');
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->dateTime('cancels_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->timestamps();

            $table->unique(['plan_id', 'team_id']);

            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
                ->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_subscriptions');
    }
}
