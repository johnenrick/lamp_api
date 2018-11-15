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
        ["id" => 1, "description" => 'Unopened', "color" => "#6c757d", "has_schedule" => 0, "is_active" => 1],
        ["id" => 2, "description" => 'Disqualify', "color" => "#dc3545", "has_schedule" => 0, "is_active" => 0],
        ["id" => 3, "description" => 'Scheduled', "color" => "#007bff", "has_schedule" => 1, "is_active" => 1],
        ["id" => 4, "description" => 'Re-call', "color" => "#ffc107", "has_schedule" => 1, "is_active" => 1],
        ["id" => 5, "description" => 'Not Interested', "color" => "#6c757d", "has_schedule" => 0, "is_active" => 0],
        ["id" => 6, "description" => 'Acceptance', "color" => "#28a745", "has_schedule" => 0, "is_active" => 1],
        ["id" => 7, "description" => 'Follow Up', "color" => "#17a2b8", "has_schedule" => 1, "is_active" => 1],
        ["id" => 8, "description" => 'Declined', "color" => "#dc3545", "has_schedule" => 0, "is_active" => 0],
        ["id" => 9, "description" => 'Closed', "color" => "#343a40", "has_schedule" => 0, "is_active" => 0]
      ];
      DB:: table('client_account_statuses') -> insert($statuses);
    }
}
