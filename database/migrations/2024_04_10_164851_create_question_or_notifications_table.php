<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOrNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_or_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('option_id')->nullable();
            $table->foreign('option_id')->references('id')->on('question_options')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('sub_option_id')->nullable();
            $table->foreign('sub_option_id')->references('id')->on('sub_options')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('title_en')->nullable();
            $table->text('title_hi')->nullable();
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
        Schema::dropIfExists('question_or_notifications');
    }
}
