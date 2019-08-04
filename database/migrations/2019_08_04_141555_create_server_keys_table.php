<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_keys', function (Blueprint $table) {
            $table->primaryUuid('id');

            $table->string('name');
            $table->text('content');

            $table->timestamps();
        });

        Schema::create('key_server', function (Blueprint $table) {
            $table->uuid('server_id');
            $table->uuid('key_id');

            $table->primary(['server_id', 'key_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_keys');
    }
}
