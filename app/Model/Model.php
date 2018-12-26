<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午1:44
 */

namespace App\Model;
 use Illuminate\Database\Eloquent\Model As BaseModel;

class Model extends BaseModel
{
    protected function filter($value)
    {
        $table_column = $this->getFields();
        $fields = array_column($table_column, 'field');
        $value_fields = array_keys($value);
        $fields = array_diff($value_fields, $fields);
        foreach ($fields as $v) {
            unset($value[$v]);
        }
        return $value;
    }


    protected function getFields()
    {
        $table = config('database')['prefix'].$this->table;
        $table_column = app('database')::select("SELECT COLUMN_NAME as field, DATA_TYPE as type, COLUMN_COMMENT as exp FROM information_schema.COLUMNS WHERE table_name = '{$table}'");
        $table_fields = [];
        foreach ($table_column as $v) {
            $table_fields[$v->field] = $v;
        }
        return $table_fields;
    }
}