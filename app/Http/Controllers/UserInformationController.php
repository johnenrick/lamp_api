<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserInformationController extends GenericController
{
  function __construct(){
    $this->tableStructure = [
      'columns' => [
        'gender' => [
          'validation' => 'required|enum'
        ]
      ]
    ];
    $this->initGenericController();
  }
}
