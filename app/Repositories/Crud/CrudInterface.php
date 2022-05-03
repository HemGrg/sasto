<?php

namespace App\Repositories\Crud;

interface CrudInterface
{
    public function all();
    public function first();
    public function find($id);
    public function delete();
    public function destroy($id);
    public function orderBy($prop, $type = null);
    public function where($column, $operator, $value);
    public function orWhere($column, $operator, $value);
    public function orWhereBetween($column, $range);
    public function whereBetween($column, $range);
    public function groupBy($column);
    public function whereDate($column, $date);
    public function whereMonth($column, $month);
    public function whereYear($column, $year);
}
