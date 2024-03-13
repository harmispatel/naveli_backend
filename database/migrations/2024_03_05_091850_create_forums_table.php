<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_category_id')->nullable();
            $table->foreign('forum_category_id')->references('id')->on('forum_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('forum_subcategory_id')->nullable();
            $table->foreign('forum_subcategory_id')->references('id')->on('forum_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('forums');
    }
}
