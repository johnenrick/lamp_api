<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAccountContactDetail extends GenericModel
{
  protected $validationRuleNotRequired = ['email', 'contact_number_2', 'contact_number_3'];
  protected $validationRules = [
    'email' => 'email'
  ];
}
