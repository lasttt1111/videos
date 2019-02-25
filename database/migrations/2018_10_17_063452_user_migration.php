<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('alias', 150)->unique();
            $table->string('name', 150);
            $table->string('email', 150)->unique();
            $table->string('password', 150);
            $table->text('avatar')->nullable();
            $table->text('cover')->nullable();
            $table->tinyInteger('permission')->default(3);
            $table->text('remember_token')->nullable();
            $table->dateTime('create_at')->nullable();
            $table->dateTime('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
