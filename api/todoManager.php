<?php
require 'db.php'; // データベース接続設定を読み込み

class ToDoManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addTodo($title, $description)
    {
        try {
            $sql = "INSERT INTO todos (title, description) VALUES (:title, :description)";
            $stmt = $this->pdo->prepare($sql);
            $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
            $safeDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
            $stmt->bindParam(':title', $safeTitle);
            $stmt->bindParam(':description', $safeDescription);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateTodo($id, $title, $description)
    {
        try {
            $sql = "UPDATE todos SET title = :title, description = :description WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
            $safeDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
            $stmt->bindParam(':title', $safeTitle);
            $stmt->bindParam(':description', $safeDescription);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteTodo($id)
    {
        try {
            $sql = "DELETE FROM todos WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getTodos()
    {
        try{
            $sql = "SELECT * FROM todos ORDER BY created_at DESC";
            $stmt = $this->pdo->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $arryData = [];
            foreach ($rows as $row) {
                $arryData[] = [
                    'id' => $row['id'],
                    'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
                    'description' => htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'),
                    'isDone' => $row['isDone']
                ];
            }

            $resArray = [
                'isExist' => !empty($arryData),
                'contents' => $arryData
            ];
            echo json_encode($resArray, JSON_UNESCAPED_UNICODE);

            } catch(PDOException $e) {
                echo json_encode(['isExist' => false, 'contents' => []], JSON_UNESCAPED_UNICODE);
            }
        }
        
    // }

    public function getModal($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM todos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $resArray = [
                    'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
                    'description' => htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'),
                    'id' => $row['id']
                ];
            } else {
                $resArray = ['error' => '無効なタスクです'];
            }
    
            echo json_encode($resArray, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'error'], JSON_UNESCAPED_UNICODE);
        }

    }

    public function completeTodo($id)
    {
        $sql = "UPDATE todos SET isDone = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute([$id]);
    }
}