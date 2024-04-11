<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyDairiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_dairies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mood')->nullable();
            $table->string('music')->nullable();
            $table->string('learning')->nullable();
            $table->string('cleaning')->nullable();
            $table->string('body_care')->nullable();
            $table->text('gratitude')->nullable();
            $table->string('hang_out')->nullable();
            $table->string('sleep')->nullable();
            $table->string('work_out')->nullable();
            $table->string('screen_time')->nullable();
            $table->string('food')->nullable();
            $table->text('edit')->nullable();
            $table->text('to_do_list')->nullable();
            $table->text('daily_dairy')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('daily_dairies');
    }
}
