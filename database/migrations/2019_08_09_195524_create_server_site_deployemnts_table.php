<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerSiteDeployemntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_site_deployments', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('server_site_id');
            $table->uuid('initiator_id')->nullable();
            $table->string('branch')->nullable();
            $table->string('commit_hash');
            $table->string('status', 25)->default('pending');

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
        Schema::dropIfExists('server_site_deployemnts');
    }
}
