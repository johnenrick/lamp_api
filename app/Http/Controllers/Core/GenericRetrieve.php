<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GenericRetrieve extends Controller
{
    /***
      [
        select => [
            tae =>
          ],
          [
            table
          ]
        ]
    */
    private $tableStructure;
    private $model;
    private $requestQuery;
    private $hasLeftJoinedTable;
    public $totalResult = null;
    public function __construct($tableStructure, $model, $requestQuery){
      $this->tableStructure = $tableStructure;
      $this->model = $model;
      $this->requestQuery = $requestQuery;
      $this->removeNotAllowedQuery();
      // return $this->executeQuery();
    }
    public function removeNotAllowedQuery(){
      $this->requestQuery['select'] = $this->removeUnwantedSelectForeignTable($this->requestQuery['select'], $this->tableStructure);
    }
    public function executeQuery(){
      $this->model = $this->addQueryStatements($this->model, $this->requestQuery, $this->tableStructure);
      $resultArray = $this->model->get()->toArray();
      if(isset($this->requestQuery['id']) && $this->requestQuery['id']){
        if(count($resultArray)){
          return $resultArray[0];
        }else{
          return null;
        }
      }
      $resultArray = collect($resultArray)->unique('id')->values()->all();;
      return $resultArray;
    }
    public function addQueryStatements($queryModel, $requestQuery, $tableStructure){
      $leftJoinedTable  = [];
      $select = [];
      $with = [];
      $queryModel->addSelect('id');
      foreach($requestQuery['select'] as $selectIndex => $select){ // add select statement
        if($select == null){ //column not foreign table
          $slectedColumn;
          if(isset($tableStructure['columns'][$selectIndex]['formula'])){
            $slectedColumn = $tableStructure['columns'][$selectIndex]['formula'];
          }else{
            $slectedColumn = $tableStructure['table_name'].".".$selectIndex;
          }

          $queryModel = $queryModel->addSelect(DB::raw("$slectedColumn as ".$selectIndex));
        }else{
          $with[$selectIndex] = function($queryModel2) use($select, $selectIndex, $tableStructure){
            $this->addQueryStatements($queryModel2, $select, $tableStructure['foreign_tables'][$selectIndex]);
          };
        }
      }
      $hasID = isset($requestQuery['id']) && $requestQuery['id'];
      if($hasID){
        $queryModel = $queryModel->where($tableStructure['table_name'].'.id', $requestQuery['id']);
      }else{
        isset($requestQuery['condition']) ? $queryModel = $this->addConditionStatement($queryModel, $requestQuery['condition'], $leftJoinedTable, $tableStructure) : null;
      }

      isset($requestQuery['sort']) ? $queryModel = $this->addSortStatement($queryModel, $requestQuery['sort'], $leftJoinedTable, $tableStructure) : null;
      if(isset($requestQuery['limit']) && isset2('offset', $requestQuery)){ // get the total page first
        $this->totalResult = $queryModel->count();
      }
      isset($requestQuery['limit']) ? $queryModel = $queryModel->limit($requestQuery['limit']) : null;
      (isset($requestQuery['offset']) && $requestQuery['offset'] >= 0) ? $queryModel = $queryModel->offset($requestQuery['offset']) : null;
      // $queryModel = $queryModel->groupBy('id');
      $this->hasLeftJoinedTable = count($leftJoinedTable) ? true : false;
      return $queryModel->with($with);
    }
    public function addConditionStatement($queryModel, $requestQueryCondition, &$leftJoinedTable, $tableStructure){
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
    public function addSortStatement($queryModel, $requestQuerySort, &$leftJoinedTable, $tableStructure){
      foreach($requestQuerySort as $sort){
        $column;
        if(isset($tableStructure['columns'][$sort['column']]['formula'])){
          $column = $tableStructure['columns'][$sort['column']]['formula'];
        }else{
          $column = $sort['column'];
          $queryModel = $this->addLeftJoin($queryModel, $leftJoinedTable, $column, $tableStructure);
        }
        $queryModel = $queryModel->orderBy(DB::raw($column), $sort['order']);
      }
      return $queryModel;
    }
    /**
    Addd a left join statement on the query

    */
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
    public function removeUnwantedSelectForeignTable($requestQuerySelect, $tableStructure, $parentTable = null){
      $cleanRequestQuery = [];
      foreach($requestQuerySelect as $selectIndex => $select){
        if(is_numeric($selectIndex) && isset($tableStructure['columns'][$select])){ // if column
          $cleanRequestQuery[$select] = null;
        }else if(isset($tableStructure['foreign_tables'][$selectIndex]) && isset($select['select'])){ // if with
          $cleanRequestQuery[$selectIndex]['select'] = $this->removeUnwantedSelectForeignTable($select['select'], $tableStructure['foreign_tables'][$selectIndex], $tableStructure['table_name']);
          isset($select['condition']) ? $cleanRequestQuery[$selectIndex]['condition'] = $select['condition']: null;

        }
      }
      $cleanRequestQuery['id'] = null;
      if($parentTable){
        $cleanRequestQuery[str_singular($parentTable)."_id"] = null;
      }
      return $cleanRequestQuery;
    }
}
