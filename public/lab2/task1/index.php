<?php
//1 - робота з cookie

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        //видаляємо cookie, ставимо час у минулому
        setcookie("username", "", time() - 3600, "/");
    } else {
        $name = trim($_POST["name"] ?? "");
        if ($name !== "") {
            //зберігаємо ім'я в cookie на 7 днів
            setcookie("username", $name, time() + 7 * 24 * 60 * 60, "/");
        }
    }
    //перезавантажуємо сторінку, щоб побачити cookie
    header("Location: index.php");
    exit;
}

//беремо ім'я з cookie
$username = $_COOKIE["username"] ?? "";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Cookie</title>
</head>
<body>
    <h2>Робота з cookie</h2>

    <?php if ($username !== ""): ?>
        <p>Привіт, <?= htmlspecialchars($username) ?>!</p>
        <form method="post">
            <button type="submit" name="delete">Видалити cookie</button>
        </form>
    <?php else: ?>
        <form method="post">
            <label for="name">Ваше ім'я:</label>
            <input type="text" id="name" name="name">
            <button type="submit">Зберегти</button>
        </form>
    <?php endif; ?>
</body>
</html>
