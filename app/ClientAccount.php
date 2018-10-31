<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAccount extends GenericModel
{
    protected $validationRule = [
      'client_account_status_id' => 'required|enum'
    ];
    protected $validationRuleNotRequired = [
      'client_account_status_id'
    ];
    public function systemGenerateValue($data){
      if(!isset2('id', $data) || !$data['id']){
        $data['client_account_status_id'] = 1;
      }
      return $data;
    }

    protected $formulatedColumn = [
      'full_address' => "CONCAT(address, ', ', city, ', ', province)"
    ];
    public function client_account_contact_details()
    {
        return $this->hasMany('App\ClientAccountContactDetail');
    }
    public function client_account_status_histories()
    {
        return $this->hasMany('App\ClientAccountStatusHistory');
    }
    public function client_account_status()
    {
        return $this->belongsTo('App\ClientAccountStatus');
    }
}
