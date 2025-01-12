<?php
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$allowedIp = '65.108.21.152'; // айпи-адрес сайта
$clientIp = $_SERVER['REMOTE_ADDR'];
$secretKey = '123';
$secret = isset($_GET['secret']) ? $_GET['secret'] : '';
if ($clientIp !== $allowedIp) {
    echo 'failure ip';
    exit;
}
if ($secret !== $secretKey) {
    http_response_code(403); 
    exit;
}
$filename = 'need_verif.txt';
$ips = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($secret === $secretKey) {
if (in_array($ip, $ips)) {
    http_response_code(200); // IP уже верифицирован
    echo 'IP already verified';
} else {
    // Добавляем новый IP и верифицируем
    file_put_contents($filename, $ip . PHP_EOL, FILE_APPEND);
    http_response_code(200); // Добавляем новый IP и верифицируем
    echo 'IP verified and added';
}
}
?>
