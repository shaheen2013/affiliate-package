<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paid_user_id')->unsigned();
            $table->decimal('paid_amount', 8, 2)->unsigned();
            $table->integer('income_user_id')->unsigned();
            $table->tinyInteger('income_commission')->unsigned();
            $table->decimal('income_amount', 8, 2)->unsigned();
            $table->timestamps();

            $table->foreign('paid_user_id')->references('id')->on('users');
            $table->foreign('income_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate_incomes');
    }
}
