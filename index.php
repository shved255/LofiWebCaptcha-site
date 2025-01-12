<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameBase64 = $_GET['username'];
    if (!$usernameBase64) {
        $failureMessage = 'Проверка не пройдена, повторите попытку снова.\n Перейдите строго по ссылке которую вам сгенерировали.'; //если username равен null
        $showFailure = true;
    } else {
        $username = base64_decode($usernameBase64);
        $recaptchaResponse = $_POST['g-recaptcha-response']; 
        if ($recaptchaResponse) { 
            $userIp = $_SERVER['REMOTE_ADDR']; 
            $secretSite = '123';
            $result = file_get_contents("http://109.172.91.185:7777/v2652166.hosted-by-vdsina.ru/check-ip.php?username=$username&ip=$userIp&secret=$secretSite");
            if ($result === 'success') { 
                $successMessage = "Поздравляем, $username! Вы успешно прошли проверку."; 
                $showSuccess = true;
                file_get_contents("http://109.172.91.185:7777/v2652166.hosted-by-vdsina.ru/save-verif.php?ip=$username/$userIp&secret=$secretSite");
                header("Refresh: 3; url=https://www.google.com");
            } else {
                $failureMessage = 'Проверка не пройдена, неверный IP-адрес или Вы не нуждаетесь в проверке. 
                Попробуйте зайти с устройства на котором вы играете.'; 
                $showFailure = true;
            }
        } else {
            $failureMessage = 'Пожалуйста, пройдите проверку reCAPTCHA.'; 
            $showFailure = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReCAPTCHA Example</title>
    <style> 
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            margin: 0;
            transition: background 0.5s ease;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 2em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .g-recaptcha {
            margin-top: 20px;
        }
        .submit-btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .success-container, .failure-container {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: none;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        .success-container:hover, .failure-container:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .success-message, .failure-message {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .failure-container {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<noscript>
   <p>Ваш браузер не поддерживает JavaScript, попробуйте обновить браузер или зайти с другого устройства!</p>
</noscript>
<div id="form-container" class="container" style="<?php echo isset($showSuccess) || isset($showFailure) ? 'display: none;' : ''; ?>">
    <h1>ReCAPTCHA Example</h1> 
    <form id="recaptcha-form" method="post">
        <div class="g-recaptcha" data-sitekey="6Lf48XIqAAAAAOEGxhRzWCL1sh7VgQYfSRRfcCCw"></div>
        <button type="submit" class="submit-btn">Пройти проверку</button> 
    </form>
</div>
<div id="success-container" class="success-container" style="<?php echo isset($showSuccess) ? 'display: block;' : ''; ?>">
    <div class="success-message" id="success-message"><?php echo isset($successMessage) ? $successMessage : ''; ?></div>
    <button class="submit-btn" onclick="window.location.href = 'https://www.google.com';">Перейти на Google</button> 
</div>
<div id="failure-container" class="failure-container" style="<?php echo isset($showFailure) ? 'display: block;' : ''; ?>">
    <div class="failure-message" id="failure-message"><?php echo isset($failureMessage) ? $failureMessage : ''; ?></div>
    <button class="submit-btn" onclick="window.location.href = 'https://www.google.com';">Перейти на Google</button>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
