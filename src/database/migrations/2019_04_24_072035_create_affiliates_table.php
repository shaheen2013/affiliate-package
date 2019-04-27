<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->text('promotion_message');
            $table->string('website_url');
            $table->enum('commission_type', ['Percentage','Amount'])->default('Percentage');
            $table->tinyInteger('commission')->unsigned()->nullable();
            $table->string('affiliate_code')->nullable();
            $table->integer('use_limit')->nullable();
            $table->string('user_code')->nullable();
            $table->integer('banner_id')->unsigned()->nullable();
            $table->enum('status', ['Pending','Approved','Rejected'])->default('Pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates');
    }
}
