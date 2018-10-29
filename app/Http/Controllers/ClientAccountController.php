<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App;
class ClientAccountController extends GenericController
{
  function __construct(){
    $this->model = new App\ClientAccount();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        'client_account_contact_details' => [],
        'client_account_status_histories' => []
      ]
    ];
    $this->initGenericController();
  }
  public function changeStatus(Request $request){
    if(!auth()->user()){
      $this->responseGenerator->setFail(["code" => 2, "message" => "Not Logged In"]);
      return $this->responseGenerator->generate();
    }
    $statuses = (new App\ClientAccountStatuses())->select('id', 'has_calendar')->get()->toArray();
    $data = $request->all();
    // printR($data);
    $validator = $this->validator($data, [
      "id" => "required|exists:client_accounts,id",
      "client_account_status_id" => [
        "required",
        "exists:client_account_statuses,id",
      ]
    ]);
    if($validator->fails()){
      $this->responseGenerator->setFail([
        "code" => 1,
        "message" => $validator->errors()->toArray()
      ]);
      $this->validationErrors = $validator->errors()->toArray();
    }else{
      $statusHistorySaved = (new App\ClientAccountDiary())->createEntry([
        "user_id" => auth()->user()->id,
        "client_account_id" => $data["id"],
        "content" => json_encode([
          "new_status" => $data["client_account_status_id"],
          "date" => null,
          "type" => 3
        ])
      ]);
      $this->responseGenerator->setSuccess($statusHistorySaved);
    }

    return $this->responseGenerator->generate();
  }
}
