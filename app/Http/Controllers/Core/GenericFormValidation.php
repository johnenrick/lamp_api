<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GenericFormValidation extends Controller
{
  private $validationRule = [];
  private $tableStructure;
  private $apiOperation = 'update';
  private $uniqueValidationRule = [];
  public $validationErrors = null;
  public function __construct($tableStructure, $apiOperation = 'update'){
    $this->tableStructure = $tableStructure;
    $this->apiOperation = $apiOperation;
    $this->generateValidationRule();
  }
  public function extractValidationRule($tableStructure, $foreignTableName = null){
    //TODO make this function recursive
    foreach($tableStructure['columns'] as $column => $columnSetting){
      if($this->apiOperation == 'create' && ((strpos( $column, "_id" ) && str_replace('_id', '', $column) == str_singular($this->tableStructure['table_name'])) || $column == 'id' )){ // exclude primary and foreign key in create operation

      }else{
        $prefix = '';
        if($foreignTableName){
          $isPlural = str_plural($foreignTableName) == $foreignTableName ? true : false;
          $prefix = $foreignTableName.".".(($isPlural) ? '*.' :'');
        }
        $rules = isset($columnSetting['validation'])?  explode("|", $columnSetting['validation']) : [];
        $finalizedRule = [];
        foreach($rules as $rule){
          $ruleNameParameterSegment = explode(":", $rule);
          switch($ruleNameParameterSegment[0]){
            case "unique":

              if(strpos($ruleNameParameterSegment[1],",except,id")){
                if(!isset($this->uniqueValidationRule[$prefix . $column])){
                  $this->uniqueValidationRule[$prefix . $column] = [];
                }
                $this->uniqueValidationRule[$prefix . $column] = str_replace(',except,id', '', $ruleNameParameterSegment[1]);
              }else{
                $finalizedRule[] = $rule;
              }

              break;
            case "required":
              if($foreignTableName && !$tableStructure['validation_required']){

              }else{
                if($this->apiOperation == "create"){
                  $finalizedRule[] = $rule;
                }else{
                  $finalizedRule[] = 'min:1';
                }
              }


              break;
            case "required_with":
              if($foreignTableName){
                $modifiedRule = $ruleNameParameterSegment[0].":";
                $parameters = explode(",", $ruleNameParameterSegment[1]);
                foreach($parameters as $index => $parameter){
                  $parameters[$index] = str_replace('*.', '*',$prefix).$parameter;
                }
                $finalizedRule[] = $modifiedRule.implode(",", $parameters);
              }else{
                $finalizedRule[] = $rule;
              }
              break;
            default:
              if($rule != ''){
                $finalizedRule[] = $rule;
              }
          }
        }
        $this->validationRule[$prefix . $column] = $finalizedRule;
      }
    }
    if(count($tableStructure['foreign_tables'])){
      foreach($tableStructure['foreign_tables'] as $foreignTable => $foreignTableStructure){
        $this->extractValidationRule($foreignTableStructure, $foreignTable);
      }

    }
  }
  public function initializeRule(){

  }
  public function generateValidationRule(){
    $this->extractValidationRule($this->tableStructure);

    return $this->validationRule;
  }
  public function isValid($data){
    if(count($this->uniqueValidationRule)){

      foreach($this->uniqueValidationRule as $field => $rule){
        if(!isset($this->validationRule[$field])){
          $this->validationRule[$field] = [];
        }
        if($this->apiOperation == "create"){
          $this->validationRule[$field][] = "unique:".$rule;
        }else{
          $data['id'] = isset($data['id'])? $data['id'] : null;
          $this->validationRule[$field][] = "unique:".$rule.','.$data['id'];
        }
      }
    }
    if($this->apiOperation == "update"){
      $this->validationRule['id'] = "required";
    }
    $validator = Validator::make($data, $this->validationRule);
    if($validator->fails()){
      // TODO reformat validation message.
      $this->validationErrors = $validator->errors()->toArray();
      return false;
    }else{
      return true;
    }
  }
}
