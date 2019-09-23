<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScriptsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->primaryUuid('id');

            $table->belongsToUser();

            $table->string('name');
            $table->text('description')->nullable();

            $table->boolean('public')->default(false)->index();
            $table->boolean('multiple_execution')->default(false);

            $table->longText('script');
            $table->json('meta')->nullable();

            $table->timestamps();
        });

        Schema::create('script_server', function (Blueprint $table) {
            $table->belongsToServer();
            $table->uuid('script_id');
            $table->uuid('task_id');

            $table->timestamp('created_at')->nullable();

            $table->primary(['script_id', 'server_id']);
            $table->foreign('script_id')
                ->references('id')
                ->on('scripts')
                ->onDelete('cascade');

            $table->foreign('task_id')
                ->references('id')
                ->on('server_tasks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('script_server');
        Schema::dropIfExists('scripts');
    }
}
