<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('flash_screen')->nullable();
            $table->longText('term_and_condition')->nullable();
            $table->longText('contact_us_page')->nullable();
            $table->longText('description')->nullable();
            $table->longText('contact_us_page')->nullable();
            $table->longText('about_us')->nullable();
            $table->string('title_page')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
