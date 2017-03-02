<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameServersTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('host_server_id')->unsigned();
            $table->integer('players');
            $table->integer('port');
            $table->smallInteger("installed")->default(0); // 0: not installed, 1: installing, 2: installed
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('host_server_id')->references('id')->on('host_servers');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_servers');
    }
}
