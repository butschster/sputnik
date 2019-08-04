<?php

use App\Models\Server\Task;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_tasks', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->uuid('server_id')->index();
            $table->string('name');
            $table->string('user', 25);
            $table->string('status', 25)->default(Task::STATUS_PENDING);
            $table->integer('exit_code')->nullable();
            $table->longText('script');
            $table->longText('output')->nullable();
            $table->text('options');

            $table->timestamps();

            $table->index('created_at');

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
        Schema::dropIfExists('server_tasks');
    }
}
