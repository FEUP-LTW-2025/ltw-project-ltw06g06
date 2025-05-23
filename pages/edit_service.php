<?php


    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/service.tpl.php');



    $db = getDatabase();
    $serviceId = htmlspecialchars((string)$_GET['id']);
    $service = Service::getServiceById((int) $serviceId);
    drawMainHeader(array());
    drawEditServiceForm($service);
    drawFooter();


?>
