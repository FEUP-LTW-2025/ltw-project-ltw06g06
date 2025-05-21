<?php
    declare(strict_types = 1);
    session_start();
    require_once('../database/database.db.php');
    require_once('../templates/request.tpl.php');

    
    $db = getDatabase();
    $user = $_SESSION['userId'];
    $requests = Request::getCustomRequestsFromArtist($db,(int)$user);
    echo json_encode($requests);
?>