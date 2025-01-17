<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->string('name');
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique();
            $table->string('lang', 5)->default(config('app.locale'));
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_alert_received_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
