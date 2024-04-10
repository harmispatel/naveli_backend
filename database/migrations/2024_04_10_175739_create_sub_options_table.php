<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_or_notification_id')->nullable();
            $table->foreign('question_or_notification_id')->references('id')->on('question_or_notifications');
            $table->string('option',255)->nullable();
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
        Schema::dropIfExists('sub_options');
    }
}
