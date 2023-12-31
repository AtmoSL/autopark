<?php

namespace service;

class Model
{
    static string $table;
    private static $fieldsSTR = '';
    private static $withSTR = '';
    private static $whereStr = '';

    /**
     * Создание поля в таблице
     * @param $data
     * @param bool $withId
     * @return void|bool
     */
    public static function create($data, bool $withId = false )
    {
        $table = static::$table;

        $fields = array_keys($data);
        $fieldsStr = implode(", ", $fields);

        $values = "";

        for ($i = 1; $i <= count($fields); $i++) {
            $values .= "?" . (($i != count($fields)) ? ", " : "");
        }

        $stmt = DataBase::prepare("INSERT INTO `$table` ($fieldsStr) VALUES ($values)");

        $i = 1;
        foreach ($data as $value) {
            $stmt->bindValue($i, $value);
            $i++;
        }

        $stmt->execute();

        if($withId){
            return DataBase::lastInsertId();
        }
    }

    /**
     * Создание условия для поиска
     * @param array $where
     * @param $fields
     * @return mixed
     */
    public static function where(array $where, array $conditions, $fields = ["*"])
    {
        $table = static::$table;

        if ($fields === ["*"]) {
            self::$fieldsSTR = "*";
        } else {
            self::$fieldsSTR = " " . $table . "." . implode(", $table.", $fields);
        }

        $i = 0;
        foreach ($where as $whereField => $whereValue) {
            self::$whereStr .= static::$table . "." . $whereField . $conditions[$i] . " '" . $whereValue . "'" . (($i != count($where) - 1) ? " AND " : "");
            $i++;
        }

        return new static();
    }

    /**
     * Создание связи с другой таблицей
     * @param $withTable
     * @param array $conditions
     * @param array|null $fields
     * @return $this
     */
    public function with($withTable, array $conditions, array $fields = null)
    {
        if ($fields) {
            self::$fieldsSTR .= ", " . $withTable . "." . implode(", $withTable.", $fields);
        }

        $conditionsSTR = implode(", ", $conditions);
        self::$withSTR .= " INNER JOIN $withTable ON $conditionsSTR";

        return $this;
    }

    /**
     * Создание связи с другой таблицей через left join
     * @param $withTable
     * @param array $conditions
     * @param array|null $fields
     * @return $this
     */
    public function withLeft($withTable, array $conditions, array $fields = null)
    {
        if ($fields) {
            self::$fieldsSTR .= ", " . $withTable . "." . implode(", $withTable.", $fields);
        }

        $conditionsSTR = implode(", ", $conditions);
        self::$withSTR .= " LEFT JOIN $withTable ON $conditionsSTR";

        return $this;
    }

    /**
     * Получение информации из таблицы
     * @return mixed
     */
    public function find()
    {
        $stmt = DataBase::prepare("SELECT " . self::$fieldsSTR .
            " FROM " . static::$table . self::$withSTR .
            " WHERE " . self::$whereStr);

        $this->reset();

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Сброс параметров
     * @return void
     */
    private function reset()
    {
        self::$fieldsSTR = '';
        self::$withSTR = '';
        self::$whereStr = '';
    }


    /**
     * Установка новых значений в БД
     * @param $data
     * @return void
     */
    public function set($data)
    {
        $table = static::$table;
        $fieldsStr = "";

        foreach ($data as $field => $value){
            $fieldsStr.= $field . " = '$value' ". (($value != end($data)) ? ", " : "");
        }

        $stmt = DataBase::prepare("UPDATE `$table` SET $fieldsStr WHERE ". self::$whereStr);

        $this->reset();

        $stmt->execute();
    }

    /**
     * Получение всех записей
     * @param $fields
     * @return static
     */
    public static function all(array $fields = ["*"])
    {
        $table = static::$table;

        if ($fields === ["*"]) {
            self::$fieldsSTR = "*";
        } else {
            self::$fieldsSTR = " " . $table . "." . implode(", $table.", $fields);
        }

        self::$whereStr = 1;

        return new static();
    }

    public static function delete(array $where, array $conditions)
    {
        $table = static::$table;

        $i = 0;
        foreach ($where as $whereField => $whereValue) {
            self::$whereStr .= static::$table . "." . $whereField . $conditions[$i] . " '" . $whereValue . "'" . (($i != count($where) - 1) ? " AND " : "");
            $i++;
        }

        $stmt = DataBase::prepare("DELETE FROM `$table` WHERE ". self::$whereStr);

        self::$whereStr = "";

        $stmt->execute();
    }
}