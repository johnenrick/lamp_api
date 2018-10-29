<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function(Blueprint $table){
        $table->increments('id');
        $table->string('username', 100);
        $table->unsignedInteger('user_type_id')->default(1);
        $table->string('email', 100);
        $table->string('password');
        $table->tinyInteger('status')->comment('0 - Not activated, 1 - activated, 2 - rejected, 3 - deactivated')->default(0);
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
