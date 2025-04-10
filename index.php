<?php 

    declare(strict_types = 1);
    session_start();

    require_once(__DIR__.'database/database.db.php');
    require_once(__DIR__.'template/common.tpl.php');

    $db = getDatabase();
    drawMainHeader();

?>