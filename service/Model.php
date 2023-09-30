<?php

namespace service;

class Model
{
    static string $table;

    /**
     * Создание поля в таблице
     * @param $data
     * @return void
     */
    public static function create($data)
    {
        $table = static::$table;

        $fields = array_keys($data);
        $fieldsStr = implode(", ", $fields);

        $stmt=DataBase::prepare("INSERT INTO `$table` ($fieldsStr) VALUES (?,?,?)");

        $i = 1;
        foreach ($data as $value){
            $stmt->bindValue($i, $value);
            $i++;
        }

        $stmt->execute();
    }

    /**
     * Получение объектов из таблицы по условию
     * @param array $where
     * @param $fields
     * @return mixed
     */
    public static function where(array $where, $fields = ["*"])
    {
        $table = static::$table;
        $whereStr = '';

        if($fields===["*"]){
            $fieldsSTR = "*";
        }else{
            $fieldsSTR = " " . $table . "." . implode(",", $fields);
        }


        foreach ($where as $whereField => $whereValue) {
            $whereStr .= static::$table . "." . $whereField . "= '" . $whereValue . "'". (($whereValue != end($where)) ? " AND " : "");
        }

        $stmt=DataBase::prepare("SELECT " . $fieldsSTR . " FROM " . static::$table . " WHERE " . $whereStr);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS);
    }
}