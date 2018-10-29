<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAccountContactDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client_account_contact_details', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('client_account_id');
        $table->string('person');
        $table->string('position');
        $table->string('contact_number_1');
        $table->string('contact_number_2')->nullable();
        $table->string('contact_number_3')->nullable();
        $table->string('email');
        $table->timestamps();
        $table->softDeletes();
        $table->foreign('client_account_id')->references('id')->on('client_accounts');
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
