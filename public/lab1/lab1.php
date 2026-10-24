<?php
//Лабораторна робота 1

echo "<meta charset='UTF-8'>";

//Пункт 1
echo "<h2>1. Hello, World!</h2>";
echo "Hello, World!<br>";

//Пункт 2
echo "<h2>2. Змінні та типи даних</h2>";
$text = "Привіт";
$integer = 42;
$float = 3.14;
$bool = true;

echo "Рядок: $text<br>";
echo "Ціле число: $integer<br>";
echo "Дробове число: $float<br>";
//для bool пишемо true або false, бо echo true виведе 1
echo "Булеве значення: " . ($bool ? "true" : "false") . "<br>";

//var_dump показує тип змінної
echo "<pre>";
var_dump($text);
var_dump($integer);
var_dump($float);
var_dump($bool);
echo "</pre>";

//Пункт 3
echo "<h2>3. Конкатенація рядків</h2>";
$str1 = "Hello";
$str2 = "PHP";
//склеюємо рядки через крапку
$result = $str1 . " " . $str2;
echo $result . "<br>";

//Пункт 4
echo "<h2>4. Парне чи непарне</h2>";
$number = 7;
//перевірка на парне число
if ($number % 2 == 0) {
    echo "Число $number парне<br>";
} else {
    echo "Число $number непарне<br>";
}

//Пункт 5
echo "<h2>5. Цикли</h2>";

//цикл for від 1 до 10
echo "for: ";
for ($i = 1; $i <= 10; $i++) {
    echo $i . " ";
}
echo "<br>";

//цикл while від 10 до 1
echo "while: ";
$j = 10;
while ($j >= 1) {
    echo $j . " ";
    $j--;
}
echo "<br>";

//Пункт 6
echo "<h2>6. Асоціативний масив</h2>";
$student = [
    "name" => "Сергій",
    "surname" => "Пшеничко",
    "age" => 19,
    "specialty" => "Графічний дизайн",
];

//виводимо кожен елемент
foreach ($student as $key => $value) {
    echo "$key: $value<br>";
}

//додаємо середній бал
$student["average_grade"] = 5;

echo "<br><b>Оновлений масив:</b><br>";
foreach ($student as $key => $value) {
    echo "$key: $value<br>";
}
