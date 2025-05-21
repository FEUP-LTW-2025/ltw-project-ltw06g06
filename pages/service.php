<?php 

    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');
    require_once('../database/review.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/service.tpl.php');
    require_once('../templates/review.tpl.php');


    $db = getDatabase();
    $id = htmlspecialchars($_GET['id']);
    updateRating($db,(int)$id);
    updateService($db,(int)$id);
    $service = Service::getServiceById((int)$id);
    drawMainHeader(array());
    if(isServiceFromArtist($db,(int) $id ,(int) $_SESSION['userId'])){
        drawService($service,true);
        $reviews = Review::getAllReviewsFromService((int)$id);
        drawReviewsForService($reviews);
    }
    else{
        drawService($service);
        $reviews = Review::getAllReviewsFromService((int)$id);
        drawReviewsForService($reviews);
        if(userBoughtService($db, (int)$_SESSION['userId'] ,(int)$id) && !userAlreadyReviewed($db, (int)$_SESSION['userId'], (int)$id)){
            drawReviewForm();
        }
        else if(userAlreadyReviewed($db, (int)$_SESSION['userId'], (int)$id)){
            drawErrorBox('You already left a review for this service');
        }
        else if(isset($_SESSION['username'])){
            drawErrorBox('You cannot leave a review for a service did not bought');
        }
        else{
            drawErrorLoginBox('Please log in to leave a review');
        }
    }
    drawFooter();
?>