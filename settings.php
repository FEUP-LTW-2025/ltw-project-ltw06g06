<?php

    declare(strict_types = 1);
    session_start();    
    require_once('database/database.db.php');
    require_once('database/user.class.php');
    require_once('templates/common.tpl.php');
    $db = getDatabase();
    $users = User::getNotAdmins($db);
    $stats = getSiteStatisticsLast7Days($db);
    drawAdminPannel($users,$stats);
    drawFooter();


?>