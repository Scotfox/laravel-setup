<?php
//5 - запис і читання файлу log.txt

$logFile = __DIR__ . "/log.txt";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //прибираємо пробіли і переноси рядків
    $text = trim($_POST["text"] ?? "");
    $text = str_replace(["\r", "\n"], " ", $text);

    if ($text === "") {
        $message = "Текст не може бути пустим.";
    } else {
        //дописуємо рядок в кінець файлу
        $line = date("Y-m-d H:i:s") . " - " . $text . PHP_EOL;
        file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
        $message = "Текст записано у файл.";
    }
}

//читаємо файл по рядках
$lines = [];
if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>log.txt</title>
</head>
<body>
    <h2>Вміст файлу log.txt</h2>

    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (count($lines) === 0): ?>
        <p>Файл пустий.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($lines as $line): ?>
                <li><?= htmlspecialchars($line) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="index.html">Назад</a></p>
</body>
</html>
