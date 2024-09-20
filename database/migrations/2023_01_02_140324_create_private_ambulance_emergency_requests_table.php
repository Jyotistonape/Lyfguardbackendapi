<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateAmbulanceEmergencyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_ambulance_emergency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('counter');
            $table->integer('admin_id');
            $table->integer('ambulance_id');
            $table->integer('booking_manager_id')->nullable();
            $table->integer('driver_id');
            $table->dateTime('request_time');
            $table->dateTime('action_time')->nullable();
            $table->integer('notify_to')->default(1)->comment('1 - Driver, 2 - Booking Manager');
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
        Schema::dropIfExists('private_ambulance_emergency_requests');
    }
}
