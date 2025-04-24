<?php

    declare(strict_types = 1);
    session_start();

    require_once('database/database.db.php');
    require_once('database/service.class.php');

    require_once('templates/common.tpl.php');
    require_once('templates/service.tpl.php');


    $category = $_GET['c'];
    $db = getDatabase();
    $categories = getCategories();
    drawMainHeader($categories);
    $services = Service::getServicesByCategory($category);
    drawServicesByCategory($services,$category);
    drawFooter();

?>