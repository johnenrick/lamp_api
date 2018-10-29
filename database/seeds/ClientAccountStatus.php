<?php

use Illuminate\Database\Seeder;

class ClientAccountStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB:: table('client_account_statuses')->truncate();
      $statuses = [
        ["id" => 1, "description" => 'unopened', "color" => "#6c757d", "has_calendar" => 0],
        ["id" => 2, "description" => 'disqualify', "color" => "#dc3545", "has_calendar" => 0],
        ["id" => 3, "description" => 'scheduled', "color" => "#007bff", "has_calendar" => 1],
        ["id" => 4, "description" => 're_call', "color" => "#ffc107", "has_calendar" => 1],
        ["id" => 5, "description" => 'not_interested', "color" => "#6c757d", "has_calendar" => 0],
        ["id" => 6, "description" => 'acceptance', "color" => "#28a745", "has_calendar" => 0],
        ["id" => 7, "description" => 'follow_up', "color" => "#17a2b8", "has_calendar" => 1],
        ["id" => 8, "description" => 'declined', "color" => "#dc3545", "has_calendar" => 0],
        ["id" => 9, "description" => 'closed', "color" => "#343a40", "has_calendar" => 0]
      ];
      DB:: table('client_account_statuses') -> insert($statuses);
    }
}
