<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends GenericModel
{
    protected $hidden = array('password');
    // protected $fillable = ['user_id', 'first_name', 'middle_name', 'last_name', 'mobile_number', 'gender', 'birthdate', 'occupation'];
    protected $validationRules = [
      'email' => 'required|email|unique:users,email,except,id',
      'password' => 'required|min:4'
    ];
    protected $defaultValue = [
      'middle_name' => ''
    ];
    protected $validationRuleNotRequired = ['username', 'user_type_id', 'middle_name', 'status'];
    public function systemGenerateValue($data){
      (isset($data['email'])) ? $data['username'] = $data['email'] : null;
      (isset($data['password'])) ? $data['password'] = Hash::make($data['password']) : null;
      $data['user_type_id'] = 2;
      if(!isset($data['id']) || $data['id'] == 0){ // if create
        $data['status'] = 0;
      }
      return $data;
    }
    
    public function user_information()
    {
        return $this->hasOne('App\UserInformation');
    }
    public function user_bank_account()
    {
        return $this->hasOne('App\userBankAccount')->orderBy('created_at', 'desc');
    }
}
