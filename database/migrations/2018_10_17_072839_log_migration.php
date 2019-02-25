<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->enum('level', ['normal', 'info', 'warning', 'error'])->default('normal');
            $table->unsignedBigInteger('user_id');

            $table->text('url')->nullable();
            $table->text('ip')->nullable();
            $table->text('data')->nullable();
            $table->text('message')->nullable();

            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
