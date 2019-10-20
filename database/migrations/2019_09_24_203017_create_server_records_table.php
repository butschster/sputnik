<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_records', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();
            $table->belongsToModule();
            $table->string('feature')->nullable();

            $table->string('key');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['server_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_records');
    }
}
