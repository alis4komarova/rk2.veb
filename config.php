
<?php
session_start();
$db_host = 'sql212.ezyro.com';
$db_user = 'ezyro_40890643';
$db_pass = 'b987480c2aeb';
$db_name = 'ezyro_40890643_ice_cream_shop';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Ошибка подключения");
}
mysqli_set_charset($conn, "utf8");

$site_name = "Ice Dream";
$site_url = "http://icecream.unaux.com";

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function safeEcho($text) {
    echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>