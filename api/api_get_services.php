<?php
    declare(strict_types = 1);
    session_start();
    require_once('../database/database.db.php');
    require_once('../database/service.class.php');

    require_once('../templates/request.tpl.php');

    
    $db = getDatabase();
    $user = $_SESSION['userId'];
    $services = Service::getServicesByArtist((int)$user);
    echo json_encode($services);
?>