<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_informations', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('user_id');
        $table->string('first_name', 50);
        $table->string('middle_name', 50)->default('');
        $table->string('last_name', 50);
        $table->string('mobile_number', 50);
        $table->enum('gender', ['male', 'female', 'gay', 'lesbian']);
        $table->date('birthdate');
        $table->string('occupation', 100);
        $table->string('address', 200);
        $table->string('city', 50);
        $table->string('province', 50);
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
