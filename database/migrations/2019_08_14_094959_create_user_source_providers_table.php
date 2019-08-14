<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSourceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_source_providers', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToUser();

            $table->string('name');
            $table->string('type', 25);
            $table->string('access_token');
            $table->string('provider_user_id');

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
        Schema::dropIfExists('user_source_providers');
    }
}
