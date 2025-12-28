<?php

namespace package\n1;

class db
{
    private $conn;
    public function __construct($host_name, $user_name, $pass_word, $db_name)
    {
        $this->conn = new \mysqli($host_name, $user_name, $pass_word, $db_name);
    }

    public function insert($table_name, $info)
    {
        $key = array_keys($info);
        $values = array_values($info);
        $key = implode(",", $key);
        $place_holders = rtrim(
            str_repeat("?,", sizeof($values)),
            ","
        );
        $sql = "INSERT INTO $table_name ($key)VALUES($place_holders);";
        $this->execute($sql, $values);
    }
    public function update($table_name, $info, $condition)
    {
        $key = array_keys($info);
        $values = array_values($info);
        for ($i = 0; $i < sizeof($key); $i++) {
            $key[$i] = $key[$i] . "=?";
        }
        $key = implode(",", $key);
        $sql = "UPDATE $table_name SET $key WHERE $condition ;";
        $this->execute($sql, $values);
    }
    public function delete($table_name, $condition)
    {
        $sql = "DELETE FROM $table_name WHERE $condition";
        $this->execute($sql, []);
    }
    public function select($table_name, $coulmns = "*", $condition = 1)
    {
        $sql = "SELECT $coulmns FROM $table_name WHERE $condition ;";
        $qu = $this->execute($sql, []);
        if ($condition == 1) {
            return $qu->fetch_all(MYSQLI_ASSOC);
        } else {
            return $qu->fetch_assoc();
        }
    }
    public function execute($sql, $val)
    {
        return $this->conn->execute_query($sql, $val);
    }
}
