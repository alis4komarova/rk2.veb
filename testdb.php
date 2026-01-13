<?php
$host = 'sql212.ezyro.com';
$dbname = 'ezyro_40890643_ice_cream_shop';
$username = 'ezyro_40890643';
$password = 'b987480c2aeb';

echo "Проверка подключения к БД...<br>";
echo "Хост: $host<br>";
echo "База: $dbname<br>";
echo "Пользователь: $username<br><br>";

error_reporting(E_ALL);
ini_set('display_errors', 1);
    
$conn = @mysqli_connect($host, $username, $password);

if (!$conn) {
    echo "Ошибка подключения к MySQL серверу: " . mysqli_connect_error();
    exit();
}

echo "Подключение к MySQL серверу успешно!<br>";

if (!mysqli_select_db($conn, $dbname)) {
    echo "Ошибка выбора базы данных '$dbname': " . mysqli_error($conn);
    exit();
}

echo "База данных '$dbname' выбрана успешно!<br>";

echo "Версия MySQL: " . mysqli_get_server_info($conn) . "<br>";

mysqli_close($conn);
?>