<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('register_user_id')->unsigned()->unique();
            $table->integer('affiliate_id')->unsigned();
            $table->integer('affiliate_user_id')->unsigned();
            $table->tinyInteger('affiliate_commission')->unsigned();
            $table->timestamps();

            $table->foreign('register_user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates');
            $table->foreign('affiliate_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate_invitations');
    }
}
