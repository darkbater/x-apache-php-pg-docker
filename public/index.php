<?php
// Включаем файл подключения к БД
require '../bin/php/db_connect.php';

// Создаем таблицу, если она не существует
$sql_create_table = "
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
    );
";

try {
    $pdo->exec($sql_create_table);
    echo "Таблица создана или уже существует.";
} catch (PDOException $e) {
    echo "Ошибка при создании таблицы: " . $e->getMessage();
}

// Проверяем, есть ли записи в таблице
$sql_check_records = "SELECT COUNT(*) FROM users;";
$stmt = $pdo->prepare($sql_check_records);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count == 0) {
    // Вставляем несколько записей
    $sql_insert = "
    INSERT INTO users (name, email) VALUES
    ('Алексей Иванов', 'alexey@example.com'),
    ('Мария Петрова', 'maria@example.com'),
    ('Иван Смирнов', 'ivan@example.com');
    ";

    try {
        $pdo->exec($sql_insert);
        // echo "Данные вставлены.";
    } catch (PDOException $e) {
        echo "Ошибка при вставке данных: " . $e->getMessage();
    }
}

// Получаем данные из таблицы
$sql_select = "SELECT * FROM users;";
$stmt = $pdo->prepare($sql_select);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список пользователей</title>
</head>
<body>
    <h1>Список пользователей</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>E-mail</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>