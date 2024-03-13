<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSymptomsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_symptoms_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('staining')->nullable();
            $table->tinyInteger('clot_size')->nullable();
            $table->tinyInteger('working_ability')->nullable();
            $table->tinyInteger('location')->nullable();
            $table->tinyInteger('cramps')->nullable();
            $table->tinyInteger('days')->nullable();
            $table->tinyInteger('collection_method')->nullable();
            $table->tinyInteger('frequency_of_change_day')->nullable();
            $table->tinyInteger('mood')->nullable();
            $table->tinyInteger('energy')->nullable();
            $table->tinyInteger('stress')->nullable();
            $table->tinyInteger('lifestyle')->nullable();
            $table->tinyInteger('acne')->nullable();
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
        Schema::dropIfExists('user_symptoms_logs');
    }
}
