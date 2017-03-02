<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("short_name", 25);
            $table->string("linuxgsm_bin");
            $table->boolean('disabled')->default(false);
            $table->integer("minplayers");
            $table->integer("maxplayers");
            $table->integer("cents_per_slots");
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
