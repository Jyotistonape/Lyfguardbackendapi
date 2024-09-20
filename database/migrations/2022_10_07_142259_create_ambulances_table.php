<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('vehicle_number');
            $table->integer('type_id');
            $table->integer('running_status')->default(0)->comment('0 - Off Duty, 1 - On Duty, 2 - On Trip');
            $table->integer('driver_id')->nullable();
            $table->date('insurance_date');
            $table->text('documents')->nullable();
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
        Schema::dropIfExists('ambulances');
    }
}
