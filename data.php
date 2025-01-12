<?php
$secretKey = '123';
$secret = isset($_GET['secret']) ? $_GET['secret'] : '';
$clientIp = $_SERVER['REMOTE_ADDR'];
$allowedIp = '65.108.21.152'; 
if ($clientIp !== $allowedIp) { 
    echo 'failure ip';
    exit;
}

if ($secret === $secretKey) {
    $filename = 'verified_ips.txt';
    if (file_exists($filename)) { 
        $content = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = array('data' => $content); 
        header('Content-Type: application/json'); 
        echo json_encode($data);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(403);
}
?>
