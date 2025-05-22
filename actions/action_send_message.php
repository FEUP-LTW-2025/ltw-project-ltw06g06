<?php
    declare(strict_types = 1);
    session_start();
    require_once('../database/database.db.php');

    $db = getDatabase();
    $receiverId = $_POST['receiverId'];
    $senderId = $_POST['senderId'];
    $serviceId= $_POST['serviceId'];
    $requestId = $_POST['requestId'];
    $message = $_POST['message'];

    sendMessage($db,(int)$receiverId,(int)$senderId,$message,$serviceId,$requestId);
    header('Location: ../pages/chat.php?user_id='.$receiverId);

?>