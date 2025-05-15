<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');


    function drawMainHeader($categories) { ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"> 
            <link rel="stylesheet" href="css/homestyle.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
            <link rel="stylesheet" href="css/loginstyle.css">
            <link rel="stylesheet" href="css/servicestyle.css">
            <link rel="stylesheet" href="css/profilestyle.css">
            <script src="javascript/payment-toggle.js" defer></script>
            <script src="javascript/searchService.js" defer></script>
            <title>Home</title>
        </head>

        <body>
            <section id="header">
                <header><h1> <a href = 'index.php'> OnlineCanvas </a></h1></header>

                <h3><?php if(!isset($_SESSION['username'])) {?>
                    <a href="login.php"> Login </a></h3>
                    <?php }
                    else{ ?>
                    <a href="actions/action_logout.php"> Logout</a></h3>
                    <?php } ?>
                    <?php if(!isset($_SESSION['username'])) {?>
                        <h3><a href="become_artist.php"> Become an Artist </a></h3>
                    <?php }
                    else if(!isArtist($_SESSION['username'])) {?>
                        <h3><a href="become_artist.php"> Become an Artist </a></h3>
                    <?php }?>
                    <?php if(!isset($_SESSION['username'])) {?>
                        <h3><a href="register.php"> Register </a></h3>
                    <?php }
                    ?>
            </section>
                <?php  if(!empty($categories)) { 
                    ?>
                <section id="menu"> 
                    <nav> 
                    <input type="checkbox" id="hamburger"> 
                    <label class="hamburger" for="hamburger"> Categories </label>
                    <ul>
                    <?php foreach ($categories as $category) {?> 
                    <li> <a href="category.php?c=<?= htmlspecialchars($category["name"])?>"> <?= htmlspecialchars($category["name"]) ?> </a></li>
                <?php }
                 ?>
                 </ul>
                </nav>
                <a id="Search" href="searchService.php"><i style='font-size:24px' class='fas'>&#xf002;</i> </a>
                <?php if(isset($_SESSION['username'])) {?>
                    <?php if(isArtist($_SESSION['username'])) {?>
                        <a id="Artist" href="artistManage.php"><i style='font-size:24px' class='fa-solid fa-clipboard-list'></i> </a>
                    <?php }
                    ?>
                    <?php if(isAdmin($_SESSION['username'])) {?>
                        <a id="Admin" href="artist.php"><i style='font-size:24px' class='fa-solid fa-gear'></i> </a>
                    <?php }
                    ?>
                    <a id="Profile" href="profile.php"><i style='font-size:24px' class='fas'>&#xf406;</i> </a>
                <?php }
                    else{ ?>
                    <a id="Profile" href="login.php"><i style='font-size:24px' class='fas'>&#xf406;</i> </a>
                    <?php } ?>

                </section>

            
    <?php }
    }

    function drawPopularServices($services) { ?>
        <header id="popular_header"><h3>Popular Services</h3></header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li> <a class="serviceInfo" href="service.php?id=<?=urlencode((string)$service->id)?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="<?= htmlspecialchars($service->image)?>" alt="Service Image" width="300" height="250">
                        <p> <?= htmlspecialchars($service->artistName) ?> </p>
                        <p> <?= htmlspecialchars((string)$service->rating) ?> </p>
                        <p> <?= htmlspecialchars($service->category) ?> </p>
                        <p> <?= htmlspecialchars((string)$service->cost) ?> </p>
                    </a>
                    </li>
                    <?php } ?>
            </section>
    <?php }

    function drawFooter() { ?>
    <footer>
        <p>&copy; 2025 OnlineCanvas. All rights reserved.</p>
    </footer>


    <?php }


    function drawErrorBox($error) { ?>
        <section class=errorBox>
        <h3> Not logged in </h3>
            <p> <?= $error ?> </p>
            <a href="login.php"> Login </a>
    </section>
    <?php }
    

?>