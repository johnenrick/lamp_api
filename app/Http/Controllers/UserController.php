<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App;
class UserController extends GenericController
{
    function __construct(){
      $this->model = new App\User();
      $this->tableStructure = [
        'columns' => [
        ],
        'foreign_tables' => [
          'user_information' => []
          // 'user_bank_account' => []
        ]
      ];
      $this->basicOperationAuthRequired["create"] = false;
      $this->initGenericController();
    }
    public function changePassword(Request $request){
      if(auth()->user() == null){
        return "You are not allowed here!";
      }
      $requestArray = $request->all();
      $validationRules = $this->model->getValidationRule();
      $validator = Validator::make($requestArray, [
        "current_password" => "required|".$validationRules['password'],
        "new_password" => "required|".$validationRules['password']
      ]);
      if($validator->fails()){
        $validator->errors()->toArray();
        $this->responseGenerator->setFail([
          "code" => 1,
          "message" => $validator->errors()->toArray()
        ]);
        return $this->responseGenerator->generate();
      }
      $user = auth()->user()->toArray();
      if(Auth::validate(["email" => $user['email'], "password" => $requestArray["current_password"]])){
        $result = $this->model->updateEntry($user['id'], ["password" => $requestArray["new_password"] ]);
        $this->responseGenerator->setSuccess($result);
      }else{
        $this->responseGenerator->setFail([
          "code" => 10,
          "message" => 'Current Password Incorrect'
        ]);
      }
      return $this->responseGenerator->generate();

    }
}
