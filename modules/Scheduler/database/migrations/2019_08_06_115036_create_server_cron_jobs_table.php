<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerCronJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_cron_jobs', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();

            $table->string('name')->nullable();
            $table->text('command');
            $table->string('user');
            $table->string('cron');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_cron_jobs');
    }
}
