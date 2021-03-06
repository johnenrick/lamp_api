<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientAccountDiary extends GenericModel
{
  protected $validationRules = [
    "client_account_id" => "required|exists:client_accounts,id"
  ];
  protected $validationRuleNotRequired = ['user_id', 'schedule'];
  public function systemGenerateValue($data){
    $data['user_id'] = $this->user("id");
    return $data;
  }
  public function client_account()
  {
      return $this->belongsTo('App\ClientAccount');
  }
}
