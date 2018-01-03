<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ravable_id');
            $table->integer('ravable_type');
            $table->integer('exchange_id');
            $table->string('referring_user_id');
            $table->string('referral_type');
            $table->integer('email');
            $table->integer('phone');
            $table->string('personal_message');
            $table->string('fullname');
            $table->tinyInteger('informed');
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
        Schema::dropIfExists('referrals');
    }
}
