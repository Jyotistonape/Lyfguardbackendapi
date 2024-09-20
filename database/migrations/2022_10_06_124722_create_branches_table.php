<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->integer('hospital_id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->integer('type_id');
            $table->string('speciality_ids');
            $table->integer('is_partner')->default(1)->comment('1 - Partner , 2 - Listing');
            $table->string('emergency_type_ids')->nullable();
            $table->string('website');
            $table->string('phone');
            $table->text('address_line1');
            $table->text('address_line2')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('pincode')->nullable();
            $table->integer('is_emergency')->default(0);
            $table->string('wallet_balance')->default(0);
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
        Schema::dropIfExists('branches');
    }
}
