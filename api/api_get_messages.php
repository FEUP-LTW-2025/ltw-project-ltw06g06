<?php
    declare(strict_types = 1);
    session_start();
    require_once('../database/database.db.php');
    $db = getDatabase();

    $receiverId = $_GET['user_id'] ?? null;

    if (!$receiverId) {
        http_response_code(400);
        echo json_encode(["error" => "Missing user_id"]);
        exit;
    }

    $messages = getMessages($db,$_SESSION['userId'], $receiverId);

    echo json_encode($messages);
?>