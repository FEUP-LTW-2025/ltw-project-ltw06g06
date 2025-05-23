<?php
    declare( strict_types = 1);
    require_once('database/database.db.php');

    updateAllServices();
    updateAllArtists();
 
    header('Location: pages/index.php');
?>