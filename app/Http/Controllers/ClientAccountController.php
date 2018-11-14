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
        'client_account_status' => [
          "validation_required" => false
        ],
        'client_account_contact_details' => [],
        'client_account_status_histories' => []
      ]
    ];
    $this->initGenericController();
  }
  public function systemGenerateRetrieveParameter($data){
    if($this->user('user_type_id') != 1){
      if(!isset($data['condition'])){
        $data['condition'] = [];
      }
      $data['condition'][] = [
        "column" => "user_id",
        "value" => $this->user('id')
      ];
    }
    return $data;
  }
  public function changeStatus(Request $request){
    if(!auth()->user()){
      $this->responseGenerator->setFail(["code" => 2, "message" => "Not Logged In"]);
      return $this->responseGenerator->generate();
    }
    $statuses = (new App\ClientAccountStatuses())->select('id', 'has_schedule')->get()->toArray();
    $data = $request->all();
    // printR($data);
    $validator = $this->validator($data, [
      "id" => "required|exists:client_accounts,id",
      "client_account_status_id" => [
        "required",
        "exists:client_account_statuses,id",
      ],
      "schedule" => $statuses['has_schedule'] ? "required" : ""
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
          "message" => isset($data["note"]) ? $data["note"] : null,
          "new_status" => isset($data["client_account_status_id"]) ? $data["client_account_status_id"] : null,
          "date" => null
        ]),
        "type" => 3,
        "schedule" => isset($data["schedule"]) ? $data["schedule"] : null,
      ]);
      $resultObject = $this->createUpdateEntry($data, "update");
      $this->responseGenerator->setSuccess($resultObject['success']);
      $this->responseGenerator->setFail($resultObject['fail']);
    }

    return $this->responseGenerator->generate();
  }
}
