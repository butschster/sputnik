<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Module\Mysql\Models\Database;

class CreateServerMysqlDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_mysql_databases', function (Blueprint $table) {
            $table->primaryUuid('id');
            $table->belongsToServer();
            $table->belongsToModule();

            $table->string('name');
            $table->string('password');
            $table->string('character_set')->default(Database::DEFAULT_CHARACTER_SET);
            $table->string('collation')->default(Database::DEFAULT_COLLATION);

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
        Schema::dropIfExists('server_databases');
    }
}
