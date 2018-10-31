<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserBankAccountController extends GenericController
{
  function __construct(){
    $this->model = new App\UserBankAccount();
    $this->tableStructure = [
      'columns' => [
      ]
    ];
    $this->initGenericController();
  }

  function change(Request $request){
    if(!$this->checkAuthenticationRequirement(true)){
      return $this->responseGenerator->generate();
    }
    $requestData = $request->all();
    $validation = new Core\GenericFormValidation($this->tableStructure, "create");

    if($validation->isValid($requestData)){
      $genericDelete = new Core\GenericDelete($this->tableStructure, $this->model);
      $condition = [[
        "column" => "user_id",
        "value" => $this->user['id']
      ]];
      $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
      $this->responseGenerator->setSuccess($genericCreate->create($requestData));
    }else{
      $this->responseGenerator->setFail([
        "code" => 1,
        "message" => $validation->validationErrors
      ]);
    }
    return $this->responseGenerator->generate();
  }
}
