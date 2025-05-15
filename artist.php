<?php
    declare(strict_types = 1);
    session_start();
    require_once('database/database.db.php');
    require_once('database/service.class.php');
    require_once('database/user.class.php');
    require_once('database/artist.class.php');
    require_once('templates/common.tpl.php');
    require_once('templates/service.tpl.php');
    require_once('templates/profile.tpl.php');


    $db = getDatabase();
    $id = htmlspecialchars($_GET['id']);
    $artist = Artist::getArtist((int)$id);
    drawMainHeader(array());
    drawArtistProfile($artist);
    $services = Service::getServicesByArtist((int)$id);
    drawServiceList($services, $id);
    drawFooter();


?>