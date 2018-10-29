<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenericDelete extends Controller
{
  protected $tableStructure = null;
  protected $model = null;
  public function __construct($tableStructure, $model){
    $this->tableStructure = $tableStructure;
    $this->model = $model;
  }
  public function delete($id = null, $condition){
    $result = $this->deleteEntryRecursively($id, $condition, $this->model,$this->tableStructure);
    return $result;
  }
  public function deleteEntryRecursively($id = null, $condition = null, $model, $tableStructure){
    $result = [];
    $entryToSave = $this->entryAllowedData($condition, $tableStructure);
    $condition ? $model = $this->addConditionStatement($model, $condition, $tableStructure) : null;
    $result['deleted'] = $model->deleteEntry($id);
    $result['id'] = $entryToSave['id'];
    // TODO option to delete children
    return $result;
  }
  public function addConditionStatement($queryModel, $requestQueryCondition, $tableStructure){
    foreach($requestQueryCondition as $condition){
      $column;
      if(isset($tableStructure['columns'][$condition['column']]['formula'])){
        $column = $tableStructure['columns'][$condition['column']]['formula'];
      }else{
        $column = $condition['column'];
        $queryModel = $this->addLeftJoin($queryModel, $leftJoinedTable, $column, $tableStructure);
      }
      $condition['clause'] = isset($condition['clause']) ? $condition['clause'] : '=';
      switch($condition['clause']){
        default:
        $queryModel = $queryModel->where($column, $condition['clause'], $condition['value']);
      }
    }
    return $queryModel;
  }
  public function addLeftJoin($queryModel, &$leftJoinedTable, &$column, $tableStructure){
    $columnSplitted = explode(".", $column);
    if(count($columnSplitted) == 2){ // table.column
      $table = $columnSplitted[0];
      if(in_array($table, $leftJoinedTable)){
        return $queryModel;
      }
      $tablePlural = str_plural($table);
      $mainTable = $tableStructure['table_name'];
      if(isset($tableStructure['foreign_tables'][$table])){
        if($tableStructure['foreign_tables'][$table]['is_child']){
          // $queryModel = $queryModel->join($tablePlural, str_plural($mainTable).".id", "=", $tablePlural.".".str_singular($mainTable)."_id");
          $queryModel = $queryModel->join($tablePlural, function($join) use ($mainTable, $tablePlural){
            $join->on(str_plural($mainTable).".id", '=', $tablePlural.".".str_singular($mainTable)."_id");
          });
        }else{
          $queryModel = $queryModel->join($tablePlural, $tablePlural.".id", "=", str_plural($mainTable).".".str_singular($table)."_id");
        }
      }
      $leftJoinedTable[] = $tablePlural;
      $column = $tablePlural.".".$columnSplitted[1];
    }else{
      $column = $tableStructure['table_name'].".".$column;
    }

    return $queryModel;
  }
  public function entryAllowedData($entry, $tableStructure){
    $entryToSave = [];
    foreach($tableStructure['columns'] as $column => $value){
      $entryToSave[$column] = isset($entry[$column]) ? $entry[$column] : null;
    }
    return $entryToSave;
  }
}
