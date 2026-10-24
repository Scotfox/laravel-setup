<?php
//4 - корзина (сесія + cookie)
session_start();

//товари: назва => ціна
$products = [
    "mouse" => ["Миша bleody", 500],
    "keyboard" => ["Клавіатура хатор", 1200],
    "monitor" => ["Монітор єлджі", 6500],
    "headphones" => ["Навушники логітех", 1500],
    "webcam" => ["Веб-камера hd якість", 900],
    "flash" => ["Флешка usb-k1ll3r", 300],
];

//корзина лежить в сесії
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

//попередні покупки беремо з cookie
$previous = json_decode($_COOKIE["previous_purchases"] ?? "[]", true);
if (!is_array($previous)) {
    $previous = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "add") {
        $id = $_POST["id"] ?? "";
        //додаємо тільки якщо такий товар є
        if (isset($products[$id])) {
            $_SESSION["cart"][] = $id;
        }
    } elseif ($action === "clear") {
        $_SESSION["cart"] = [];
    } elseif ($action === "buy" && count($_SESSION["cart"]) > 0) {
        //переносимо товари з корзини в попередні покупки
        foreach ($_SESSION["cart"] as $id) {
            $previous[] = $products[$id][0];
        }
        //залишаємо останні 10
        $previous = array_slice($previous, -10);
        //зберігаємо в cookie на 30 днів
        setcookie("previous_purchases", json_encode($previous, JSON_UNESCAPED_UNICODE), time() + 30 * 24 * 60 * 60, "/");
        $_SESSION["cart"] = [];
    }

    header("Location: index.php");
    exit;
}

//рахуємо суму
$total = 0;
foreach ($_SESSION["cart"] as $id) {
    $total += $products[$id][1];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
    <h2>Магазин комп'ютерної периферії</h2>

    <h3>Товари</h3>
    <?php foreach ($products as $id => $product): ?>
        <form method="post">
            <?= $product[0] ?> - <?= $product[1] ?> грн
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit">Додати</button>
        </form>
    <?php endforeach; ?>

    <h3>Корзина</h3>
    <?php if (count($_SESSION["cart"]) === 0): ?>
        <p>Корзина пуста</p>
    <?php else: ?>
        <ul>
            <?php foreach ($_SESSION["cart"] as $id): ?>
                <li><?= $products[$id][0] ?> - <?= $products[$id][1] ?> грн</li>
            <?php endforeach; ?>
        </ul>
        <p>Разом: <?= $total ?> грн</p>
        <form method="post">
            <button type="submit" name="action" value="buy">Купити</button>
            <button type="submit" name="action" value="clear">Очистити</button>
        </form>
    <?php endif; ?>

    <h3>Попередні покупки</h3>
    <?php if (count($previous) === 0): ?>
        <p>Поки що немає</p>
    <?php else: ?>
        <ul>
            <?php foreach ($previous as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
