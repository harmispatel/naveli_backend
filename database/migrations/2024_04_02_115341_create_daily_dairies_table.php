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
            $table->string('mood')->nullable();
            $table->string('music')->nullable();
            $table->string('learning')->nullable();
            $table->string('cleaning')->nullable();
            $table->string('body_care')->nullable();
            $table->text('gratitude')->nullable();
            $table->string('hang_out')->nullable();
            $table->string('work_out')->nullable();
            $table->string('screen_time')->nullable();
            $table->string('food')->nullable();
            $table->text('edit')->nullable();
            $table->text('key_activities')->nullable();
            $table->text('to_do_list')->nullable();
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
