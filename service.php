<?php 

    declare(strict_types = 1);
    session_start();

    require_once('database/database.db.php');
    require_once('database/service.class.php');
    require_once('database/review.class.php');
    require_once('templates/common.tpl.php');
    require_once('templates/service.tpl.php');
    require_once('templates/review.tpl.php');


    $db = getDatabase();
    $id = $_GET['id'];
    $service = Service::getServiceById((int)$id);
    drawMainHeader(array());
    drawService($service);
    $reviews = Review::getAllReviewsFromService((int)$id);
    drawReviewsForService($reviews);
    drawFooter();
?>