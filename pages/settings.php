<?php

    declare(strict_types = 1);
    session_start();    
    require_once('../database/database.db.php');
    require_once('../database/user.class.php');
    require_once('../templates/common.tpl.php');
    $db = getDatabase();
    $users = User::getNotAdmins($db);
    $stats7days = getSiteStatisticsLast7Days($db);
    $stats = getSiteStatistics($db);
    drawAdminPannel($users,$stats,$stats7days);
    drawFooter();


?>