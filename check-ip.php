<?php
$allowedIp = '109.172.91.185'; // айпи-адрес сайта
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

$username = $_GET['username']; 
$userIp = $_GET['ip'];

$verifiedIps = file('need_verif.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($verifiedIps as $line) { 
    list($storedUsername, $storedIp) = explode('/', $line);
    if ($storedUsername === $username) {
        if ($storedIp === $userIp) {
            echo 'success'; 
            exit;
        } else {
            echo 'failure'; 
            exit;
        }
    }
}

echo 'failure';
?>
