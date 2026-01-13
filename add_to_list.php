<?php
session_start();
require_once 'config.php';

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit();
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

// Проверяем подключение к БД
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД']);
    exit();
}

if ($action === 'add') {
    $product_id = intval($_POST['product_id'] ?? 0);
    
    if ($product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Неверный товар']);
        exit();
    }
    
    // Проверяем, существует ли уже товар в списке пользователя
    $check_query = "SELECT id FROM shopping_lists 
                    WHERE user_id = $user_id AND product_id = $product_id";
    $check = mysqli_query($conn, $check_query);
    
    if (!$check) {
        echo json_encode(['success' => false, 'message' => 'Ошибка запроса: ' . mysqli_error($conn)]);
        exit();
    }
    
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['success' => false, 'message' => 'Товар уже в списке']);
        exit();
    }
    
    // Добавляем товар
    $query = "INSERT INTO shopping_lists (user_id, product_id, added_at) 
              VALUES ($user_id, $product_id, NOW())";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Товар добавлен в список']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка БД: ' . mysqli_error($conn)]);
    }

} elseif ($action === 'remove') {
    $item_id = intval($_POST['item_id'] ?? 0);
    
    if ($item_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Неверный ID товара']);
        exit();
    }
    
    // Проверяем существование записи
    $check_query = "SELECT id FROM shopping_lists 
                    WHERE id = $item_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (!$check_result) {
        echo json_encode(['success' => false, 'message' => 'Ошибка проверки: ' . mysqli_error($conn)]);
        exit();
    }
    
    if (mysqli_num_rows($check_result) === 0) {
        echo json_encode(['success' => false, 'message' => 'Запись не найдена или нет прав доступа']);
        exit();
    }
    
    // Удаляем запись
    $query = "DELETE FROM shopping_lists WHERE id = $item_id AND user_id = $user_id";
    if (mysqli_query($conn, $query)) {
        // Проверяем, сколько строк было удалено
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(['success' => true, 'message' => 'Товар удален из списка']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Не удалось удалить товар']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка удаления: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Неизвестное действие']);
}
?>