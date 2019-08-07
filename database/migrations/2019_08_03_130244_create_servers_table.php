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
            $table->ipAddress('ip')->unique();
            $table->integer('ssh_port')->default(22);
            $table->string('sudo_password')->nullable();
            $table->json('meta')->nullable();

            $table->string('php_version')->default('73');
            $table->string('database_type')->nullable()->default('mysql');
            $table->string('database_password');
            $table->string('webserver_type')->nullable()->default('nginx');

            $table->text('public_key');
            $table->text('private_key');
            $table->string('key_password');

            $table->string('status', 25)->default(Server::STATUS_PENDING);

            $table->timestamp('configuring_job_dispatched_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('servers');
    }
}
