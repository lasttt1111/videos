<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlaylistMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('alias', 150)->unique();
            $table->string('title', 150);
            $table->text('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('privacy')->default(3);

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
        Schema::dropIfExists('playlists');
    }
}
