<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->integer('user_id');
            $table->double('user_latitude');
            $table->double('user_longitude'); 
            $table->integer('emergency_type_id');
            $table->integer('branch_id')->nullable(); 
            $table->integer('booking_manager_id')->nullable();
            $table->integer('ambulance_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->text('route_array')->nullable();
            $table->string('booking_manager_otp')->nullable();
            $table->string('user_otp')->nullable();
            $table->integer('driver_status')->default(0)->comment('1 - Driver En Route, 2 - Patient Picked Up, 3 - En Route to Hospital, 4 - Completed, 5 - Cancelled');
            $table->integer('status')->default(1)->comment('1 - Requested, 2 - Processing, 3 - ⁠Accepted, 4 - ⁠Assigned, 5 - ⁠In Progress, 6 - Failed, 7 - Completed, 8 - ⁠Cancelled');
            $table->text('cancel_reason')->nullable();
            $table->string('cancel_by')->nullable();
            $table->integer('cancel_by_id')->nullable();
            $table->time('respond_time')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
