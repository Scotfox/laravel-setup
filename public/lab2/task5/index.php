<?php
//5 - завершення сесії через неактивність
session_start();

//завершення сесії через 5 хв
$timeout = 300;

//перевіряємо час останньої активності
if (isset($_SESSION["user"])) {
    if (isset($_SESSION["last_activity"]) && time() - $_SESSION["last_activity"] > $timeout) {
        //користувач був неактивний, закриваємо сесію
        session_unset();
        session_destroy();
        header("Location: index.php?timeout=1");
        exit;
    }
    //оновлюємо час активності
    $_SESSION["last_activity"] = time();
}

$validLogin = "admin";
$validPassword = "1234";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }

    $login = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($login === $validLogin && $password === $validPassword) {
        $_SESSION["user"] = $login;
        //запам'ятовуємо час входу
        $_SESSION["last_activity"] = time();
        header("Location: index.php");
        exit;
    } else {
        $error = "Неправильний логін або пароль";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Неактивність</title>
</head>
<body>
    <h2>Сесія з обмеженням часу</h2>

    <?php if (isset($_GET["timeout"])): ?>
        <p style="color: red;">Сесію завершено через неактивність (більше 5 хвилин).</p>
    <?php endif; ?>

    <?php if (isset($_SESSION["user"])): ?>
        <p>Привіт, <?= htmlspecialchars($_SESSION["user"]) ?>!</p>
        <p>Сесія завершиться, якщо ви будете неактивні більше 5 хвилин.</p>
        <form method="post">
            <button type="submit" name="logout">Вихід</button>
        </form>
    <?php else: ?>
        <?php if ($error !== ""): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="login">Логін:</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="submit">Увійти</button>
        </form>
    <?php endif; ?>
</body>
</html>
