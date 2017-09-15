<?php

class DataBase
{
    private static $db;
    private static $mysqli;

    public function getConnection()
    {
        return self::$mysqli;
    }

    public static function getDB()
    {
        if (is_null(self::$db)) {
            self::$db = new self();
        }

        return self::$db;
    }

    private function __construct()
    {

        $connect = new mysqli('localhost', 'root', '');

        if ($connect->connect_error) {
            die("Connection to MySQL failed: " . $connect->connect_error);
        } else {

            // TODO: Добавить проверку успешнйо операции!
            $connect->query('CREATE DATABASE IF NOT EXISTS myDB');


            $conn = new mysqli('localhost', 'root', '', 'myDB');
            if ($conn->connect_error) {
                die("Connection to DB failed: " . $conn->connect_error);
            } else {
                $sql = "CREATE TABLE IF NOT EXISTS `gb1` (
                          `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
                          `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                          `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                          `date` DATETIME NOT NULL ,
                          PRIMARY KEY (`id`)) ENGINE = InnoDB";

                $result = $conn->query($sql);

                if (!$result) {
                    die("Error has occured while table is creating: " . $conn->error);
                }

                return self::$mysqli = $conn;
            }


        }
        return false;
    }

    public function clean($arg)
    {
        if (empty($arg)) {
            return '';
        }


        $res = htmlspecialchars($arg);
        return self::$mysqli->real_escape_string($res);


    }

    public function getPostParams($params = [])
    {
        if (!is_array($params) || empty($params)) {
            $params = $_POST;
        }

        $tempArray = [];
        $conn = self::$mysqli;

        foreach ($params as $key => $value) {
            $tempArray[$key] = $conn->real_escape_string(htmlspecialchars($value));
        }

        if ($tempArray === []) {
            return false;
        }

        return $tempArray;
    }

    public function __destruct()
    {
        if (is_null(self::$mysqli)) {
            self::$mysqli->close();
        }
    }
}
