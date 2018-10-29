<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientAccountDiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("client_account_diaries", function(Blueprint $table){
          $table->increments('id');
          $table->unsignedInteger('client_account_id');
          $table->unsignedInteger('user_id');
          $table->tinyInteger('type')->comment("1 - normal, >1 system generated, 3 - status changed, 4 - information updated")->default(1);
          $table->string('content')->comment("if it is system generated, the content is a json, else normal text");
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
