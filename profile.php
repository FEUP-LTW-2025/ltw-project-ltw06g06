<?php


declare(strict_types = 1);
session_start();

require_once('database/database.db.php');
require_once('database/service.class.php');
require_once('database/user.class.php');
require_once('templates/common.tpl.php');
require_once('templates/request.tpl.php');
require_once('templates/profile.tpl.php');

require_once('database/request.class.php');



$db = getDatabase();
drawMainHeader(array());
$user = User::getUser($_SESSION['username']);
drawProfile($user);
$requests = Request::getPendingRequestsFromUser($user->id);
drawPendingRequests($requests);
drawFooter();

?>