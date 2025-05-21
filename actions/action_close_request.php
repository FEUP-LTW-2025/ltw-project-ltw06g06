<?php

    session_start();

    require_once('../database/database.db.php');
    $serviceId = (int)$_POST['service_id'];
    $clientId = (int)$_POST['client_id'];

    $db = getDatabase();
    closeRequest($db,$serviceId,$clientId);
    header('Location: ../pages/artistManage.php')





?>