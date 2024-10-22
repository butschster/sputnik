<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_sites', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();
            $table->belongsToUser();

            $table->string('token');
            $table->uuid('webserver_id');
            $table->foreign('webserver_id')
                ->references('id')
                ->on('server_modules')
                ->onDelete('cascade');

            $table->uuid('processor_id')->nullable();
            $table->foreign('processor_id')
                ->references('id')
                ->on('server_modules')
                ->onDelete('cascade');

            $table->string('domain');
            $table->json('aliases')->nullable();
            $table->json('environment')->nullable();
            $table->string('public_dir');

            $table->string('repository')->nullable();
            $table->string('repository_provider')->nullable();
            $table->string('repository_branch')->nullable();

            $table->boolean('is_proxy')->default(false);
            $table->string('proxy_address')->nullable();

            $table->boolean('use_ssl')->default(false);

            $table->date('domain_expires_at')->nullable();
            $table->date('ssl_certificate_expires_at')->nullable();

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
        Schema::dropIfExists('server_sites');
    }
}
