<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plan_subscription_usage', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('team_id');
            $table->string('code');
            $table->smallInteger('used')->unsigned();
            $table->dateTime('valid_until')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'code']);

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
        Schema::dropIfExists('plan_subscription_usage');
    }
}
