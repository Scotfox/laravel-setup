<?php
//6 - список файлів з папки uploads

$uploadDir = __DIR__ . "/uploads/";

//якщо немає, створюємо папку
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

//беремо всі файли, прибираємо . і ..
$files = [];
foreach (scandir($uploadDir) as $item) {
    if ($item !== "." && $item !== ".." && is_file($uploadDir . $item)) {
        $files[] = $item;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список файлів</title>
</head>
<body>
    <h2>Файли в папці uploads</h2>

    <?php if (count($files) === 0): ?>
        <p>Файлів поки немає.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($files as $file): ?>
                <!--посилання для завантаження кожного файлу-->
                <li>
                    <a href="uploads/<?= rawurlencode($file) ?>" download><?= htmlspecialchars($file) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="index.html">Назад</a></p>
</body>
</html>
