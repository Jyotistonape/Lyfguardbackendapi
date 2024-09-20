<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('ambulance_id');
            $table->integer('driver_id');
            $table->dateTime('logged_in_time')->nullable();
            $table->dateTime('logged_out_time')->nullable();
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
        Schema::dropIfExists('ambulance_drivers');
    }
}
