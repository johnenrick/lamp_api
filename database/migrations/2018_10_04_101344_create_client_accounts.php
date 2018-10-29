<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client_accounts', function(Blueprint $table){
        $table->increments('id');
        $table->string('company_name');
        $table->string('business_nature');
        $table->string('company_connection')->comment("How do you know the company / person");
        $table->string('address', 200);
        $table->string('city', 50);
        $table->string('province', 50);
        $table->string('remarks')->comment("Note/s or Instruction/s or to approach company or contact person");
        $table->unsignedInteger('client_account_status_id')->default(0);  
        $table->timestamps();
        $table->softDeletes();
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
