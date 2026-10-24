<?php
//3 - робота з $_SERVER

//якщо метод не POST, перенаправляємо на іншу сторінку
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інформація</title>
</head>
<body>
    <h2>Інформація про сервер і запит</h2>
    <ul>
        <li>IP-адреса клієнта: <?= htmlspecialchars($_SERVER["REMOTE_ADDR"]) ?></li>
        <li>Браузер: <?= htmlspecialchars($_SERVER["HTTP_USER_AGENT"] ?? "невідомо") ?></li>
        <li>Скрипт: <?= htmlspecialchars($_SERVER["PHP_SELF"]) ?></li>
        <li>Метод запиту: <?= htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?></li>
        <li>Шлях до файлу: <?= htmlspecialchars($_SERVER["SCRIPT_FILENAME"]) ?></li>
    </ul>
    <a href="index.php">Назад</a>
</body>
</html>
