<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('video', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('alias', 150)->unique();
            $table->string('title', 150);
            $table->string('label', 10);
            $table->text('image')->nullable();
            $table->text('link')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->text('description')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('price')->default(0);
            $table->tinyInteger('privacy')->default(3);
            $table->string('language', 10)->default('oth');
            $table->string('password', 150)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video');
    }
}
