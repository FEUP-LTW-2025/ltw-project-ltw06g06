<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');


    function drawMainHeader($categories) { ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"> 
            <link rel="stylesheet" href="css/homestyle.css">
            <link rel="stylesheet" href="css/loginstyle.css">
            <link rel="stylesheet" href="css/servicestyle.css">
            <title>Home</title>
        </head>

        <body>
            <section id="header">
                <header><h1> <a href = 'index.php'> OnlineCanvas </a></h1></header>

                <h3><?php if(!isset($_SESSION['username'])) {?>
                    <a href="login.php"> Login </a></h3>
                    <?php }
                    else{ ?>
                    <a href="action_logout.php"> Logout</a></h3>
                    <?php } ?>
                <section class="searchbar">
                    <input type="text" name="username" placeholder="What service are you looking for?">
                    <button>Search</button>
                </section>
                <?php if(isset($_SESSION['username'])) {?>
                <h3><a href="profile.php"> Profile </a></h3>
                <?php }
                    else{ ?>
                    <h3><a href="login.php"> Profile</a></h3>
                    <?php } ?>
                <h3><a href="apply.html"> Become a Freelancer </a></h3>
            </section>
                <?php  if(!empty($categories)) { 
                    ?> <header id="category_header"><h3>Categories</h3></header>
                    <section class="horizontal_list"> 
                    <?php foreach ($categories as $category) {?> 
                    <li> <a href="category.php?c=<?= $category["name"]?>"> <?= $category["name"] ?> </a></li>
                <?php }
                }
                 ?>
            </section>
            
    <?php }

    function drawPopularServices($services) { ?>
        <header id="popular_header"><h3>Popular Services</h3></header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li> <a class="serviceInfo" href="service.php?id=<?= $service->id?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="example.jpg" alt="Service Image" width="300" height="250">
                        <p> <?= $service->artistName ?> </p>
                        <p> <?= $service->rating ?> </p>
                        <p> <?= $service->category ?> </p>
                        <p> <?= $service->cost ?> </p>
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


?>