<?php
// index.php (front controller)
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/BookController.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    die("Erro conexão: " . htmlspecialchars($e->getMessage()));
}

$controller = new BookController($pdo);
$action = $_GET['action'] ?? 'index';

// rota simples
switch ($action) {
    case 'create':
        $controller->create(); break;
    case 'store':
        $controller->store(); break;
    case 'edit':
        $controller->edit(); break;
    case 'update':
        $controller->update(); break;
    case 'delete':
        $controller->delete(); break;
    case 'index':
    default:
        $controller->index(); break;
}
