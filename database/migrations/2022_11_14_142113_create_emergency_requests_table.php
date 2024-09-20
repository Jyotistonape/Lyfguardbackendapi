<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('counter');
            $table->integer('branch_id')->nullable();
            $table->integer('booking_manager_id')->nullable();
            $table->integer('ambulance_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->dateTime('request_time');
            $table->dateTime('action_time')->nullable();
            $table->integer('status')->default(1)->comment('1 - Pending, 2 - Accepted, 3 - Rejected, 4 - Skipped');
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
        Schema::dropIfExists('emergency_requests');
    }
}
