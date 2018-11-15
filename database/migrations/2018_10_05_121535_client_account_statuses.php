<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientAccountStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client_account_statuses', function(Blueprint $table){
        $table->increments('id');
        $table->char('description', 20);
        $table->char('color', 10);
        $table->boolean('has_schedule');
        $table->boolean('is_active');
        // $table->unsignedInteger('status', ['unopened', 'disqualify', 'scheduled', 're_call', 'not_interested', 'acceptance', 'follow_up', 'declined', 'closed']);
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
