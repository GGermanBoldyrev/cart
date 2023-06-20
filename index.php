<?php

// Коннект к бд
require 'vendor/connection.php';

// Стартуем сессию
session_start();

// Запрос на получение товара
$sql = "SELECT * FROM products";
$data = $pdo->prepare($sql);
$data->execute([]);

// Кол-во товара
$quantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $quantity += $item['quantity'];
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
            <ul>
                <li><a href="/">Главная</a></li>
                <?php
                if ($quantity < 1) {
                    echo '<li><a href="empty-cart.php">Корзина</a></li>';
                } else {
                    echo "<li><a href='cart.php'>Корзина ($quantity)</a></li>";
                }
                ?>
            </ul>
        </div>
        <div>
            <table>
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>В корзину</th>
                </tr>
                <?php foreach($data->fetchAll() as $item):?>
                    <tr class="items">
                        <td><?=$item['name']?></td>
                        <td><?=$item['price']?> руб.</td>
                        <td><a href="vendor/add-cart.php?id=<?=$item['id']?>" class="add-item">Добавить +</a></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</body>
</html>

<style>
    body {
        background-color: dimgray;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: whitesmoke;
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

    table {
        border: 1px solid whitesmoke;
        width: 600px;
        padding: 15px;
        border-collapse:separate; 
        border-spacing: 0 1.25em;
    }

    th {
        font-size: 24px;
    }

    td {
        font-size: 18px;
    }

    tr {
        text-align: center;
    }

    .page {
        display: grid;
        place-items: center;
        height: 500px;
    }

    .nav {
        width: 350px;
    }

    .add-item {
        border: 1px solid whitesmoke;
        border-radius: 5px;
        padding: 3px 10px;
        width: fit-content;
    }

    .add-item:hover {
        text-decoration: none;
        background-color: green;
    }

</style>