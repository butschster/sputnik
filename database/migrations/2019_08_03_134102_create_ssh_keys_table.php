<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSshKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssh_keys', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('user_id')->index();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('server_ssh_key', function (Blueprint $table) {
            $table->uuid('server_id');
            $table->uuid('ssh_key_id');

            $table->unique('server_id', 'ssh_key_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ssh_keys');
    }
}
