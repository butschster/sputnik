<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_deployments', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();
            $table->nullableUuidMorphs('owner');
            $table->uuid('initiator_id')->nullable();
            $table->string('path');
            $table->json('environment');
            $table->string('repository');
            $table->string('branch');
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
        Schema::dropIfExists('server_deployments');
    }
}
