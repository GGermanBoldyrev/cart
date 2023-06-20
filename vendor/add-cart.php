<?php

// Стартуем сессию
session_start();

// PDO connect
require 'connection.php';

// Id продукта для добавления
$id = $_GET['id'];

// Если товар уже лежит в корзине
if (isset($_SESSION['cart'][$id])) {
    // Увеличиваем количество товара
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    // SQL запрос
    $sql = "SELECT * FROM products WHERE id = :id";
    $data = $pdo->prepare($sql);
    $data->execute([
        ':id' => $id
    ]);
    // Если такой id существует в БД
    if($data->rowCount() > 0) {
        $_SESSION['cart'][$id]['quantity'] = 1;
    }
}

// Закрытие скрипта
header("Location: $_SERVER[HTTP_REFERER]");
exit();