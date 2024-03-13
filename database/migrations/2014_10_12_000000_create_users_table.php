<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->date('birthdate')->nullable();
            $table->integer('gender')->nullable();
            $table->string('gender_type')->nullable();
            $table->string('random_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('device_token')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('relationship_status')->default(0);
            $table->string('average_cycle_length')->nullable();
            $table->string('previous_periods_begin')->nullable();
            $table->string('average_period_length')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
