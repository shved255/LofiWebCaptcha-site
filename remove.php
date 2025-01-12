<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$filename = isset($_GET['file']) ? $_GET['file'] : '';
$allowedIp = '65.108.21.152'; // айпи-адрес сервера с вебкапчей
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
if ($secret === $secretKey && !empty($id) && !empty($filename)) {
    // Проверяем, существует ли файл
    if (file_exists($filename)) {
        // Читаем содержимое файла в массив
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Удаляем строку с указанным id
        $newLines = array_filter($lines, function($line) use ($id) {
            return trim($line) !== $id; // Сравниваем с id
        });
        // Записываем обновленный массив обратно в файл
        file_put_contents($filename, implode(PHP_EOL, $newLines) . PHP_EOL);
        http_response_code(200); // Успех
    } else {
        http_response_code(404); // Файл не найден
    }
} else {
    http_response_code(403); // Доступ запрещен
}
?>
