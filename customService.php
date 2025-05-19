<?php
    declare(strict_types = 1);
    session_start();
    require_once('database/database.db.php');
    require_once('database/service.class.php');
    require_once('database/user.class.php');
    require_once('templates/common.tpl.php');
    require_once('templates/service.tpl.php');


    $db = getDatabase();
    $categories = getCategories();
    drawMainHeader($categories);
    drawCustomServiceForm();

    drawFooter();
    




?>