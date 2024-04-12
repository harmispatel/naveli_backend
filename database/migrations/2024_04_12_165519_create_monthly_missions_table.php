<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_missions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('main_focus_of_month')->nullable();
            $table->string('goals')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('habits_to_cut')->nullable();
            $table->string('habits_to_adopt')->nullable();
            $table->string('new_things_to_try')->nullable();
            $table->string('family_goals')->nullable();
            $table->string('books_to_read')->nullable();
            $table->string('movies_to_watch')->nullable();
            $table->string('places_to_visit')->nullable();
            $table->text('make_wish')->nullable();
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
        Schema::dropIfExists('monthly_missions');
    }
}
