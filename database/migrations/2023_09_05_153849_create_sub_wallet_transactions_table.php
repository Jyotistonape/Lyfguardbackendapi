<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('hospital_id');
            $table->integer('branch_id');
            $table->string('balance')->default(0);
            $table->string('amount');
            $table->text('comment')->default('Added By Admin');
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
        Schema::dropIfExists('sub_wallet_transactions');
    }
}
