<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerDaemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_supervisor_daemons', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();
 
            $table->text('command');
            $table->string('user');
            $table->string('directory')->nullable();
            $table->unsignedInteger('processes');

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
        Schema::dropIfExists('server_supervisor_daemons');
    }
}
