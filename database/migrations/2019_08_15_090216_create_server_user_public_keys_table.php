<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerUserPublicKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_user_public_keys', function (Blueprint $table) {
            $table->primaryUuid('id');

            $table->uuid('server_user_id')->index();

            $table->string('name');
            $table->text('key');

            $table->foreign('server_user_id')
                ->references('id')
                ->on('server_users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('server_user_public_keys');
    }
}
