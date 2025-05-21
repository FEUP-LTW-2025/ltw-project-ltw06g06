<?php

    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/request.tpl.php');
    require_once('../database/request.class.php');
    require_once('../database/user.class.php');


    $db = getDatabase();
    $userId = $_SESSION['userId'];
    $requests = Request::getRequestsFromArtist($userId);

    drawMainHeader(array());
    drawArtistManagement();
    drawFooter();







?>