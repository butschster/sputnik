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
            $table->uuid('server_id');

            $table->string('token');

            $table->string('domain');
            $table->json('aliases')->nullable();
            $table->json('environment')->nullable();
            $table->string('public_dir');

            $table->string('repository')->nullable();
            $table->string('repository_provider')->nullable();
            $table->string('repository_branch')->nullable();

            $table->timestamps();

            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
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
        Schema::dropIfExists('server_sites');
    }
}
