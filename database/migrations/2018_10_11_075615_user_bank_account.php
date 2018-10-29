<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_bank_accounts', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('user_id');
        $table->string('bank', 50);
        $table->string('bank_branch', 50);
        $table->string('account_number', 50);
        $table->string('account_name', 50);
        $table->boolean('verified')->default(0);
        $table->timestamps();
        $table->softDeletes();
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
        //
    }
}
