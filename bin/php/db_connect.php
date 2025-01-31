<?php
# Параметры подключения
$db_host = getenv('POSTGRES_HOST')      ?: 'db';
$db_port = getenv('POSTGRES_PORT')      ?: '5432';
$db_name = getenv('POSTGRES_DB')        ?: 'app_database';
$db_user = getenv('POSTGRES_USER')      ?: 'user';
$db_pass = getenv('POSTGRES_PASSWORD')  ?: 'password';

try {
    // Создаем новое подключение PDO
    $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;";
    $pdo = new PDO($dsn, $db_user, $db_pass);

    // Устанавливаем режим ошибок PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Можно проверить подключение
    // echo "Успешное подключение к базе данных!";
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit;
}
?>