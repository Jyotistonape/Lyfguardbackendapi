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
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->string('referral_key')->nullable();
            $table->string('referrer_key')->nullable();
            $table->integer('role');
            $table->text('image');
            $table->integer('org_id')->nullable();
            $table->string('fcm_token')->nullable();
            $table->integer('duty_status')->default(0);
            $table->integer('notify_to')->default(1)->comment('1 - Driver, 2 - Booking Manager');
            $table->integer('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
