<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title', 32);
            $table->string('detail', 1024);
            $table->date('due_date');
            $table->date('start_date');
            $table->integer('status')->default(1);
            $table->timestamps();

            //$table->foreign('user_id')->references('id')->on('users');
            //$table->primary(['id']);
        });
        /*
        Schema::table('todos', function (Blueprint $table) {
            $table->increments('id')->change();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
