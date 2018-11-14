<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends GenericModel
{
  protected $validationRules = [
    'gender' => 'required|enum',
    'birthdate' => 'required|date_format:Y-m-d',
    'address' => 'required|max:200',
    'city' => 'required|max:50',
    'province' => 'required|max:50'

  ];
  protected $defaultValue = [
    'middle_name' => ''
  ];
  protected $formulatedColumn = [
    'full_name' => "CONCAT(last_name, ', ', first_name)",
    'full_address' => "CONCAT(address, ', ', city, ', ', province)"
  ];
  public $validationRuleNotRequired = ['middle_name'];
  public function systemGenerateValue($entry){
    // if(isset2('id', $entry) && $this->user()){
    //   $entry['user_id'] = $this->user("id");
    // }
    return $entry;
  }
}
