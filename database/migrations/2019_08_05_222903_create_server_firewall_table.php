<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerFirewallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_firewall_rules', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('server_id');
            $table->boolean('editable')->default(true);

            $table->string('name');
            $table->string('port')->nullable();
            $table->enum('protocol', ['tcp', 'udp'])->nullable();
            $table->ipAddress('from')->nullable();
            $table->enum('policy', ['allow', 'deny'])->default('allow');

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
        Schema::dropIfExists('server_firewall');
    }
}
