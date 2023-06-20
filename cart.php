<?php

// Коннект к бд
require 'vendor/connection.php';

// Старуем сессию
session_start();

// Кол-во товара
$quantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $quantity += $item['quantity'];
}

// Массив id элементов из корзины
$ids = [];
foreach ($_SESSION['cart'] as $id => $value) {
    $ids[] = $id;
}

// Если товара нет в корзине, то переходим на страницу с пустой корзиной
if ($quantity < 1) {
    header("Location: /empty-cart.php");
    exit();
}

// SQL запрос
$in = str_repeat('?,', count($ids) - 1) . '?';
$sql = "SELECT * FROM products WHERE id IN ($in)";
$data = $pdo->prepare($sql);
$data->execute($ids);

// Общая стоимость
$total_price = 0;

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
                <li><a href="cart.php">Корзина (<?= $quantity?>)</a></li>
            </ul>
        </div>
        <div>
            <h2>Корзина</h2>
            <table>
                <tr>
                    <th>Название товара</th>
                    <th>Стоимость</th>
                    <th>Колчиество</th>
                    <th>Общая стоимость</th>
                </tr>
                <?php foreach($data->fetchAll() as $item):
                    $quantity = $_SESSION['cart'][$item['id']]['quantity'];
                    $total_price += $item['price'] * $quantity;
                ?>
                    <tr class="items">
                        <td><?=$item['name']?></td>
                        <td><?=$item['price']?> руб.</td>
                        <td class="quantity">
                            <?= $quantity?>
                            <div>
                                <a href="vendor/delete-cart.php?id=<?=$item['id']?>">-</a>
                                <a href="vendor/add-cart.php?id=<?=$item['id']?>">+</a>
                            </div>
                        </td>
                        <td><?= $item['price'] * $quantity?> руб.</td>
                    </tr>
                <?php endforeach;?>
            </table>
            <h2>Общая стоимость заказа: <?= number_format($total_price)?> рублей</h2>
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
        width: 800px;
        padding: 15px;
        border-collapse:separate; 
        border-spacing: 0 1.25em;
    }

    th {
        font-size: 20px;
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

    .quantity {
        display: flex;
        justify-content: center;
    }

    .quantity div {
        margin-left: 10px;
    }

    .quantity a:hover {
        text-decoration: none;
        color: greenyellow;
    }

</style>