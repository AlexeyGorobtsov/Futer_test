<?php
require_once 'connect.php';
/*===================функция по преоборазованию и экранированию символов====================*/

//$name = DataBase::getDB()->clean($_POST['name']);
//$text = DataBase::getDB()->clean($_POST['text']);

$params = DataBase::getDB()->getPostParams();

if ($params) {
    $name = isset($params['name']) ? $params['name'] : null;
    $text = isset($params['text']) ? $params['text'] : null;

    if (empty($name) || empty($text)) {
        die("123");
    }

    $date = date("Y-m-d H:i:s");
    $query = "INSERT INTO `gb1` (`name`, `text`, `date`) VALUES ('$name', '$text', '$date')";

    $result = $mysqli->query($query);

    if (!$result) {
        die("123");
    }
}
//}
$res = $mysqli->query("SELECT name, text, DATE_FORMAT(`date`, '%H:%i %d.%m.%Y') as date FROM gb1 ORDER BY id");
$messages = $res->fetch_all(MYSQLI_ASSOC);
echo json_encode($messages);
