<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_events', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('server_id');
            $table->text('message');
            $table->timestamps();
            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_events');
    }
}