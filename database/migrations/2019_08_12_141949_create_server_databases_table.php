<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_databases', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();

            $table->string('name');
            $table->string('password');
            $table->string('character_set')->default('utf8');
            $table->string('collation')->default('utf8_unicode_ci');

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
        Schema::dropIfExists('server_databases');
    }
}
