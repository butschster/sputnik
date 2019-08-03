<?php

use App\Models\Server;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->primaryUuid('id');

            $table->uuid('user_id')->index();

            $table->string('name');
            $table->ipAddress('ip');
            $table->integer('ssh_port')->default(22);
            $table->string('sudo_password');
            $table->json('meta');

            $table->string('php_version')->default('73');
            $table->string('database_type')->nullable()->default('mysql');

            $table->text('public_key');
            $table->text('private_key');
            $table->string('key_password');

            $table->string('status', 25)->default(Server::STATUS_PENDING);

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
        Schema::dropIfExists('servers');
    }
}
