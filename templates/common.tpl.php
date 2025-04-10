<?php

    declare( strict_types = 1);
    require_once(__DIR__.'/database/database.db.php');

    $categories = getCategories();


    function drawMainHeader() { ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"> 
            <link rel="stylesheet" href="homestyle.css">
            <title>Home</title>
        </head>

        <body>
            <section id="header">
                <header><h1>OnlineCanvas</h1></header>

                <h3><a href="login.html"> Login </a></h3>
                <h3><a href="login.html"> Register </a></h3>
                <section class="searchbar">
                    <input type="text" name="username" placeholder="What service are you looking for?">
                    <button>Search</button>
                </section>

                <h3><a href="systemsettings.html"> AdminSettings </a></h3>
                <h3><a href="profile.html"> Profile </a></h3>
                <h3><a href="list.html"> List a Service </a></h3>
                <h3><a href="apply.html"> Become a Freelancer </a></h3>
            </section>

                <section class="horizontal_list"> 
                    <?php foreach ($categories as $category) {?> 
                    <li> <a href="list.html"> <?= $category['name'] ?> </a></li>
                    <?php } ?>
            </section>
        </body>
        </html>
    <?php }


?>