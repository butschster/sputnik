<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->decimal('price')->default('0.00');
            $table->string('currency', 3);
            $table->smallInteger('trial_period')->unsigned()->default(0);
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
}
