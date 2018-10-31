<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;

class GenericCreate extends Controller
{
  protected $tableStructure = null;
  protected $model = null;
  public function __construct($tableStructure, $model){
    $this->tableStructure = $tableStructure;
    $this->model = $model;
  }
  public function create($entry){
    // printR($entry);
    $result = $this->createEntryRecursively($entry, $this->model,$this->tableStructure);
    return $result;
  }
  public function createEntryRecursively($entry, $model, $tableStructure){
    $result = [];
    $entryToSave = $this->entryAllowedData($entry, $tableStructure);
    $id = $model->createEntry($entryToSave);
    $result['id'] = $id;
    foreach($tableStructure['foreign_tables'] as $foreignTableName => $foreignTable){ // loop the foreign tables
      $foreignColumnName = str_singular($tableStructure['table_name']) .'_id';
      if(isset($foreignTable['columns'][$foreignColumnName]) && isset($entry[$foreignTableName])){ // insert as child && entry has foreign table

        if($foreignTable['multiple']){
          for($x = 0; $x < count($entry[$foreignTableName]); $x++){
            $foreignTableModel = new $foreignTable['model_name']();
            $entry[$foreignTableName][$x][$foreignColumnName] = $id;
            $result[$foreignTableName][$x] = $this->createEntryRecursively($entry[$foreignTableName][$x], $foreignTableModel, $foreignTable);
          }
        }else{
          $foreignTableModel = new $foreignTable['model_name']();
          $entry[$foreignTableName][$foreignColumnName] = $id;
          $result[$foreignTableName] = $this->createEntryRecursively($entry[$foreignTableName], $foreignTableModel, $foreignTable);
        }
      }
    }
    return $result;
  }
  public function entryAllowedData($entry, $tableStructure){
    $entryToSave = [];
    foreach($tableStructure['columns'] as $column => $value){
      if(!isset($value['formula'])){
        $entryToSave[$column] = isset($entry[$column]) ? $entry[$column] : null;
      }
    }
    return $entryToSave;
  }
}
