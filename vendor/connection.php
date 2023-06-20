<?php

// Для подкючения к PDO
$host = 'localhost';
$db = 'cart';
$user = 'root';
$password = '';

// Настройки подключения
$dsn = "mysql:host=$host;dbname=$db";

// Создаем инстанс PDO
$pdo = new PDO($dsn, $user, $password);

// Устанавливаем атрибуты
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);