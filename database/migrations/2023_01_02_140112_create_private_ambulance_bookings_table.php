<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateAmbulanceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_ambulance_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->integer('user_id');
            $table->double('user_latitude');
            $table->double('user_longitude');
            $table->double('user_destination_latitude');
            $table->double('user_destination_longitude');
            $table->integer('ambulance_type_id');
            $table->string('amenities_ids');
            $table->integer('admin_id')->nullable();
            $table->integer('ambulance_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('booking_manager_id')->nullable();
            $table->text('route_array')->nullable();
            $table->string('driver_otp')->nullable();
            $table->string('user_otp')->nullable();
            $table->integer('driver_status')->default(0)->comment('1 - Driver En Route, 2 - Patient Picked Up, 3 - En Route to Hospital, 4 - Completed, 5 - Cancelled');
            $table->integer('status')->default(1)->comment('1 - Requested, 2 - Processing, 3 - Approved, 4 - Failed, 5 - Completed, 6 - Cancelled');
            $table->text('cancel_reason')->nullable();
            $table->string('cancel_by')->nullable();
            $table->integer('cancel_by_id')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->date('payment_date')->nullable();
            $table->time('payment_time')->nullable();
            $table->string('payment_reference')->nullable();
            $table->integer('payment_status')->default(0);
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
        Schema::dropIfExists('private_ambulance_bookings');
    }
}
