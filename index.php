<?php

// Коннект к бд
require 'vendor/connection.php';

// Стартуем сессию
session_start();

// Пагинация
$limit = 5;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Сортировка
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'name';
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'ASC';
}

// Запрос на получение товара
$sql = "SELECT * FROM products ORDER BY $sort $order";
$data = $pdo->prepare($sql);
$data->execute([]);
$data = $data->fetchAll();

// Кол-во товара в корзине
$quantity = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $quantity += $item['quantity'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>

<body>
    <div class="page">
        <div class="nav">
            <div class="container">
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href='cart.php'>
                        <?= $quantity > 0 ? "Корзина ($quantity)" : "Корзина" ?>
                    </a></li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="select">
                <div class="select-item">
                    <div class="select-title">По названию:</div>
                    <a href="?page=<?=$page?>&sort=name&order=ASC" class="select-item">воз.</a>
                    <a href="?page=<?=$page?>&sort=name&order=DESC" class="select-item">убыв.</a>
                </div>
                <div class="select-item">
                    <div class="select-title">По цене:</div>
                    <a href="?page=<?=$page?>&sort=price&order=ASC" class="select-item">воз.</a>
                    <a href="?page=<?=$page?>&sort=price&order=DESC" class="select-item">убыв.</a>
                </div>
            </div>
            <div>
                <?php for ($i = ($page - 1) * $limit; $i <= $page * $limit; $i++) : ?>
                    <?php if(array_key_exists($i, $data)) : ?>
                        <div class="item">
                            <div class="title">
                                <div class="item-title">Название</div>
                                <div class="item-text"><?= $data[$i]['name'] ?></div>
                            </div>
                            <div class="price">
                                <div class="item-title">Цена</div>
                                <div class="item-text"><?= $data[$i]['price'] ?> руб.</div>
                            </div>
                            <div class="add">
                                <a href="vendor/add-cart.php?id=<?= $data[$i]['id'] ?>" class="add-item">Добавить +</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= ceil(count($data)) / $limit; $i++) : ?>
                    <a href="?page=<?=$i?>&sort=<?=$sort?>&order=<?=$order?>" class="page-number"><?=$i?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background-color: grey;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: whitesmoke;
        display: flex;
        justify-content: center;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    a:hover {
        cursor: pointer;
        text-decoration: underline;
    }

    ul {
        list-style: none;
        font-size: 28px;
        display: flex;
        justify-content: space-between;
    }

    .container {
        width: 1000px;
        margin: 0 auto;
    }

    .nav {
        background-color: dimgray;
        padding: 10px 0;
        width: 100vw;
        margin-bottom: 50px;
    }

    .select {
        margin-bottom: 50px;
        display: flex;
    }

    .select-item {
        margin-right: 20px;
        display: flex;
    }

    .select-title {
        color: cornsilk;
        margin-right: 10px;
    }

    .item {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        border-radius: 10px;
        background-color: dimgray;
        margin-bottom: 20px;
    }

    .item-title {
        font-size: 24px;
        color: cornsilk;
    }

    .item-text {
        font-size: 20px;
    }

    .add {
        display: flex;
        align-items: center;
    }

    .add-item {
        border: 1px solid whitesmoke;
        border-radius: 5px;
        padding: 3px 10px;
        width: fit-content;
        font-size: 18px;
    }

    .add-item:hover {
        text-decoration: none;
        background-color: green;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .pagination a:hover {
        text-decoration: none;
    }

    .page-number {
        background-color: dimgray;
        font-size: 20px;
        margin-right: 10px;
        padding: 5px 13px;
        border-radius: 50%;
    }

    .page-number:hover {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }

</style>