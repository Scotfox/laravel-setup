<?php
//2,3,4 - завантаження файлу

//папка для файлів
$uploadDir = __DIR__ . "/uploads/";
//максимальний розмір 2 МБ
$maxSize = 2 * 1024 * 1024;
//розширення
$allowed = ["png", "jpg", "jpeg"];

$errors = [];
$notice = "";
$info = null;

//якщо зайшли не з форми, повертаємо на форму
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

//якщо немає папки, створюємо її
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["file"]) || $_FILES["file"]["error"] === UPLOAD_ERR_NO_FILE) {
    $errors[] = "Ви не вибрали файл.";
} elseif ($_FILES["file"]["error"] === UPLOAD_ERR_INI_SIZE || $_FILES["file"]["error"] === UPLOAD_ERR_FORM_SIZE) {
    $errors[] = "Файл завеликий. Максимум 2 МБ.";
} elseif ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
    $errors[] = "Помилка під час завантаження файлу.";
} elseif (!is_uploaded_file($_FILES["file"]["tmp_name"])) {
    //перевіряємо, що файл справді завантажений через форму
    $errors[] = "Файл не був завантажений.";
} else {
    $tmpName = $_FILES["file"]["tmp_name"];
    $originalName = basename($_FILES["file"]["name"]);
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $size = $_FILES["file"]["size"];

    //перевірка розширення
    if (!in_array($extension, $allowed)) {
        $errors[] = "Можна завантажувати тільки png, jpg, jpeg.";
    }

    //перевірка розміру
    if ($size > $maxSize) {
        $errors[] = "Файл завеликий. Максимум 2 МБ.";
    }

    //перевіряємо що це картинка
    $imageInfo = false;
    if (empty($errors)) {
        $imageInfo = getimagesize($tmpName);
        if ($imageInfo === false) {
            $errors[] = "Цей файл не є зображенням.";
        }
    }

    if (empty($errors)) {
        //прибираємо з назви дивні символи
        $name = preg_replace('/[^\p{L}\p{N}._-]/u', "_", $originalName);

        //якщо дублікат, додаємо дату і час
        if (file_exists($uploadDir . $name)) {
            $nameWithoutExt = pathinfo($name, PATHINFO_FILENAME);
            $name = $nameWithoutExt . "_" . date("Ymd_His") . "." . $extension;
            $notice = "Файл з такою назвою вже є, тому до назви додано дату і час.";
        }

        //зберігаємо файл у папку uploads
        if (move_uploaded_file($tmpName, $uploadDir . $name)) {
            $info = [
                "name" => $name,
                "type" => $imageInfo["mime"],
                "size" => round($size / 1024, 2),
            ];
        } else {
            $errors[] = "Не вдалося зберегти файл на сервері.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результат</title>
</head>
<body>
    <h2>Результат завантаження</h2>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: green;">Файл успішно завантажено!</p>
        <?php if ($notice !== ""): ?>
            <p><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>
        <!--3 - інформація про файл-->
        <ul>
            <li>Ім'я файлу: <?= htmlspecialchars($info["name"]) ?></li>
            <li>Тип: <?= htmlspecialchars($info["type"]) ?></li>
            <li>Розмір: <?= $info["size"] ?> КБ</li>
        </ul>
        <!--посилання для завантаження файлу назад-->
        <p><a href="uploads/<?= rawurlencode($info["name"]) ?>" download>Завантажити файл</a></p>
    <?php endif; ?>

    <p><a href="index.html">Назад</a></p>
</body>
</html>
