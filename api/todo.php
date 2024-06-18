<?php
require 'db.php';
require 'todoManager.php'; 
$todoManager = new ToDoManager($pdo);
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $title = $_POST['title'];
        $description = $_POST['description'];
        $result = $todoManager->addTodo($title, $description);
        echo json_encode(['status' => $result ? true : false]);
        break;

    case 'update':
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $result = $todoManager->updateTodo($id, $title, $description);
        echo json_encode(['status' => $result ? true : false]);
        break;

    case 'complete':
        $id = $_POST['id'];
        $result = $todoManager->completeTodo($id);
        echo json_encode(['status' => $result ? true : false]);
        break;

    case 'delete':
        $id = $_POST['id'];
        $result = $todoManager->deleteTodo($id);
        echo json_encode(['status' => $result ? true : false]);
        break;

    case 'get':
        $todoManager->getTodos();
        break;
    
    case 'getModal':
        $id = $_POST['id'];
        $todoManager->getModal($id);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => '無効な処理です']);
        break;
}