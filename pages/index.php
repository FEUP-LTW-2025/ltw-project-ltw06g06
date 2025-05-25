<?php 

    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');

    require_once('../templates/common.tpl.php');
    require_once('../templates/service.tpl.php');


    $db = getDatabase();
    if (!isset($_SESSION['first_load'])){
        updateAllServices();
        updateAllArtists();
        $_SESSION['first_load'] = "yes";
    }
    $categories = getCategories();
    drawMainHeader($categories);
    $services = Service::getTopServices(18);
    drawPopularServices($services);
    drawFooter();
?>