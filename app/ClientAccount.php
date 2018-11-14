<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAccount extends GenericModel
{
    protected $validationRule = [
      'client_account_status_id' => 'required|enum'
    ];
    protected $validationRuleNotRequired = [
      'client_account_status_id',
      'user_id'
    ];
    public function systemGenerateValue($data){
      if(!isset2('id', $data) || !$data['id']){
        $data['client_account_status_id'] = 1;
      }
      if($this->user('user_type_id') != 1 || !isset2('id', $data) || !$data['id']){
        $data['user_id'] = $this->user('id');
      }
      return $data;
    }

    protected $formulatedColumn = [
      'full_address' => "CONCAT(address, ', ', city, ', ', province)",
    ];
    public function client_account_contact_details()
    {
        return $this->hasMany('App\ClientAccountContactDetail');
    }
    public function client_account_status()
    {
        return $this->belongsTo('App\ClientAccountStatus');
    }
}
