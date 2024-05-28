<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_name_en')->nullable();
            $table->string('question_name_hi')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('questionType_id')->nullable();
            $table->foreign('questionType_id')->references('id')->on('question_types')->cascadeOnDelete();
            $table->unsignedBigInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('question_type_ages')->cascadeOnDelete();
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
        Schema::dropIfExists('questions');
    }
}
