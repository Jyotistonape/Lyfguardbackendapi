<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_ambulances', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('vehicle_number');
            $table->integer('type_id');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable(); 
            $table->date('insurance_date');
            $table->text('registration_certificate');
            $table->text('zero_five_km_rate');
            $table->text('five_fifteen_km_rate');
            $table->text('fifteen_thirty_km_rate');
            $table->text('thirty_above_km_rate');
            $table->integer('running_status')->default(0)->comment('0 - Off Duty, 1 - On Duty, 2 - On Trip');
            $table->integer('driver_id')->nullable();
            $table->text('amenities')->nullable();
            $table->text('available_amenities')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('private_ambulances');
    }
}
