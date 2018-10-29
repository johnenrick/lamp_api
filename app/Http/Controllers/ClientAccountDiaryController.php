<?php

namespace App\Http\Controllers;

use App;
class ClientAccountDiaryController extends GenericController
{
  function __construct(){
    $this->model = new App\ClientAccountDiary();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    // printR(auth()->user()->toArray()););
    $this->initGenericController();
  }
}
