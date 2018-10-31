<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class ClientAccountStatusController extends GenericController
{
  function __construct(){
    $this->model = new App\ClientAccountStatus();
    $this->tableStructure = [
      'columns' => [
      ]
    ];
    $this->initGenericController();
  }
}
