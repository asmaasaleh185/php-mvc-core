<?php


namespace corepackage\phpmvc\db;

use corepackage\phpmvc\Model;
use corepackage\phpmvc\Application;

abstract class DbModel extends Model{
    abstract public function tableName(): string;

    abstract public  function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                VALUES(".implode(',', $params).")");
        
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;

        // echo "<pre>";
        // var_dump($statement, $params, $attributes);
        // echo "</pre>";
        // exit;

    }

    public static function findOne($where) {
        $instance = new static();
        $tableName = $instance->tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }
}