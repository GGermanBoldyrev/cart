<?php

// Стартуем сессию
session_start();

// PDO connect
require 'connection.php';

// Id продукта для добавления
$id = $_GET['id'];

// SQL запрос
$sql = "SELECT * FROM products WHERE id = :id";
$data = $pdo->prepare($sql);
$data->execute([
    ':id' => $id
]);

// Если такой id существует в БД и он уже в козине
if($data->rowCount() > 0 && $_SESSION['cart'][$id]) {
    // Если количество товара 0, то удаляем его из сессии
    if ($_SESSION['cart'][$id]['quantity'] > 1) {
        // Уменьшаем кол-во товара
        $_SESSION['cart'][$id]['quantity'] -= 1;
    } else {
        unset($_SESSION['cart'][$id]);
    }
}

// Закрытие скрипта
header("Location: $_SERVER[HTTP_REFERER]");
exit();