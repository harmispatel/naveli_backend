<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHirsutismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_hirsutisms', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('upper_lips')->nullable();
            $table->integer('chin')->nullable();
            $table->integer('chest')->nullable();
            $table->integer('upper_back')->nullable();
            $table->integer('lower_back')->nullable();
            $table->integer('upper_abdomen')->nullable();
            $table->integer('lower_abdomen')->nullable();
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
        Schema::dropIfExists('user_hirsutisms');
    }
}
