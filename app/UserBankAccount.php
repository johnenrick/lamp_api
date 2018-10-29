<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends GenericModel
{
  protected $fillable = ['bank', 'bank_branch', 'account_name', 'account_number'];
  protected $validationRules = [
    // 'bank' => 'required_with:bank_branch,account_name,account_number|nullable|min:4',
    // 'bank_branch' => 'required_with:bank|nullable|min:4',
    // 'account_name' => 'required_with:bank|nullable|min:4',
    // 'account_number' => 'required_with:bank|nullable|min:13'
    'bank' => 'required|min:3',
    'bank_branch' => 'required|min:4',
    'account_name' => 'required|min:4',
    'account_number' => 'required|min:13'

  ];
  public function systemGenerateValue($entry){
    if(!isset($entry['id'])){
      $entry['verified'] = 0;
    }
    return $entry;
  }
  protected $validationRuleNotRequired = ['verified'];
}
