<?php
    session_start();
    require_once('../database/database.db.php');

    $start = $_GET['start'];
    $end = $_GET['end'];
    $artistId = $_SESSION['userId'];

    $db = getDatabase();
    $stats = getArtistStatistics($db,$start,$end,(int)$artistId);

    echo json_encode($stats);
?>