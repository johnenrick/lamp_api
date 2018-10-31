<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GenericModel extends Model
{
  use SoftDeletes;
  public $parent = [];
  protected $validationRules = []; // model level validation rule
  protected $validationRuleNotRequired = [];
  private $defaultValidationInitialized = false;
  protected $defaultValue = [];
  protected $formulatedColumn = [];
  // public function children($childName){
  //   $joinedTable = $this;
  //   foreach($this->children as $childName => $child){
  //     $joinedTable = $joinedTable
  //   }
  //   return $joinedTable;
  // }
  public function getValidationRule(){
    if(!$this->defaultValidationInitialized){
      $this->initDefaultValidation();
    }
    return $this->validationRules;
  }
  public function getFormulatedColumn(){
    return $this->formulatedColumn;
  }
  public function systemGenerateValue($data){
    return $data;
  }
  public function initDefaultValidation(){
    $tableColumns = $this->getTableColumns();
    foreach($tableColumns as $tableColumn){
      $isNotRequired = in_array($tableColumn, $this->validationRuleNotRequired);
      if(!isset($this->validationRules[$tableColumn]) && !$isNotRequired){ // set required as default for no validation specified
        $this->validationRules[$tableColumn] = 'required';
      }else if(!isset($this->validationRules[$tableColumn]) && $isNotRequired ){
        $this->validationRules[$tableColumn] = '';
      }
      $rules = explode('|', $this->validationRules[$tableColumn]);

      foreach($rules as $ruleIndex => $rule){
        $explodedRuleString = explode(':', $rule); // separate rule and parameter
        switch($explodedRuleString[0]){
          case 'enum':
            $enumList = $this->getPossibleEnumValues($tableColumn);
            $rules[$ruleIndex] = 'in:'.implode(',', $enumList);
            break;

        }
      }
      $this->validationRules[$tableColumn] = implode('|', $rules);
    }
    $this->defaultValidationInitialized = true;
  }
  public function getTableColumns() {
    return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
  }
  // public function getAttributes(){
  //   return $this->attributes;
  // }
  // public function getTableDetail(){
  //   return $this->getConnection()->getSchemaBuilder()->listTableDetails("inventory");
  // }
  // public function newModel($table, $attribute){
  //   $modelName = "App\\".str_replace(' ', '', ucwords(str_replace('_', ' ', str_singular($table))));
  //   return new $modelName($attribute);
  // }
  public static function getPossibleEnumValues($name){
    $instance = new static; // create an instance of the model to be able to get the table name
    $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = array();
    foreach(explode(',', $matches[1]) as $value){
        $v = trim( $value, "'" );
        $enum[] = $v;
    }
    return $enum;
  }
  public function createEntry($entry){
    $entry = $this->systemGenerateValue($entry);

    if($entry == null){
      echo "System Generate Value has no returned data!";
      exit();
    }
    unset($entry['id']);
    unset($entry['created_at']);
    unset($entry['updated_at']);
    unset($entry['deleted_at']);
    foreach($entry as $entryColumn => $entryValue){
      $value = $entryValue;
      if($entryValue == null){
        $value = isset($this->defaultValue[$entryColumn]) ? $this->defaultValue[$entryColumn] : $entryValue;
      }
      $this->$entryColumn = $value;
    }
    $this->save();
    return $this->id;
  }
  public function updateEntry($id, $entry, $foreignColumn = null, $foreignID = 0){
    $entry = $this->systemGenerateValue($entry);
    unset($entry['id']);
    unset($entry['created_at']);
    unset($entry['updated_at']);
    unset($entry['deleted_at']);
    $currentData = $this->where('id', $id)->get()->toArray();

    foreach($entry as $entryColumn => $entryValue){
      $value = $entryValue;
      if($entryValue == null){
        $value = isset($this->defaultValue[$entryColumn]) ? $this->defaultValue[$entryColumn] : $entryValue;
      }
      if(($value == "\"\"" || $value == "''") && !is_numeric($value)){
        $value = "";
      }
      $currentData[0][$entryColumn] = $value;
    }
    if($foreignID * 1){
      $this->where($foreignColumn, $foreignID);
    }
    unset($currentData[0]['created_at']);
    unset($currentData[0]['updated_at']);
    unset($currentData[0]['deleted_at']);
    return $this->where("id", $id)->update($currentData[0]);
  }
  public function deleteEntry($id = null){
    if($id){
      return $this->where("id", $id)->delete();
    }else{
      return $this->delete();
    }
  }
  public function user($key = "id"){
    if(auth()->user()){
      $user = auth()->user()->toArray();
      return $user[$key];
    }else{
      return null;
    }
  }
}
