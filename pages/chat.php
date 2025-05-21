<?php
    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');
    require_once('../database/user.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/profile.tpl.php');
    require_once('../templates/chat.tpl.php');

    drawMainHeader(array());
    $users = array();
    $users = User::getChatUsers($_SESSION['userId']);
    $startingChat = $users[0]->id;
    drawChatBox($users, $startingChat);
    drawFooter();


?>