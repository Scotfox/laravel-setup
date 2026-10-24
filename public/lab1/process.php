<?php
echo "<meta charset='UTF-8'>";

//перевіряємо чи дані прийшли з форми
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Спочатку заповніть форму: <a href='index.html'>index.html</a>";
    exit;
}

//беремо дані і прибираємо пробіли
$name = trim($_POST["name"] ?? "");
$surname = trim($_POST["surname"] ?? "");

$errors = [];

//перевірка на пусті поля
if ($name === "") {
    $errors[] = "Ім'я не може бути пустим.";
}
if ($surname === "") {
    $errors[] = "Прізвище не може бути пустим.";
}

//дозволяємо тільки букви, пробіл, дефіс і апостроф
$pattern = "/^[\p{L}\s'\-]+$/u";
if ($name !== "" && !preg_match($pattern, $name)) {
    $errors[] = "Ім'я містить недопустимі символи.";
}
if ($surname !== "" && !preg_match($pattern, $surname)) {
    $errors[] = "Прізвище містить недопустимі символи.";
}

//якщо є помилки, показуємо їх
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo "<br><a href='index.html'>Назад</a>";
} else {
    //привітання
    echo "Привіт, " . htmlspecialchars($name) . " " . htmlspecialchars($surname) . "!";
}
