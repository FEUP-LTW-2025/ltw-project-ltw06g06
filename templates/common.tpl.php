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
            <script src="javascript/payment-toggle.js"></script>
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
                <h3><a href="apply.html"> Become an Artist </a></h3>
                <h3><a href="register.php"> Register </a></h3>
            </section>
                <?php  if(!empty($categories)) { 
                    ?>
                    <section id="menu"> 
                    <nav> 
                    <!-- just for the hamburguer menu in responsive layout -->
                    <input type="checkbox" id="hamburger"> 
                    <label class="hamburger" for="hamburger"> Categories </label>
                    <ul>
                    <?php foreach ($categories as $category) {?> 
                    <li> <a href="category.php?c=<?= $category["name"]?>"> <?= $category["name"] ?> </a></li>
                <?php }
                 ?>
                 </ul>
                </nav>
                <a id="Search"><i style='font-size:24px' class='fas'>&#xf002;</i> </a>
                <?php if(isset($_SESSION['username'])) {?>
                <a id="Profile" href="profile.php"><i style='font-size:24px' class='fas'>&#xf406;</i> </a>
                <?php }
                    else{ ?>
                    <a id="Profile" href="login.php"><i style='font-size:20px' class='fas'>&#xf406;</i> </a>
                    <?php } ?>
                </section>

            
    <?php }
    }

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

    function drawRequestForm() { ?>
       <form class="service-request-form" method="POST" action="actions/action_submit_request.php">
            <h2>Request This Service</h2>

            <input type="hidden" name="service" value="<?=$_GET['id']?>">

            <label for="description">Description of Request</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <fieldset>
                <legend>Select Payment Method</legend>
                <label><input type="radio" name="payment_method" value="credit" required> Credit Card</label>
                <label><input type="radio" name="payment_method" value="paypal"> PayPal</label>
                <label><input type="radio" name="payment_method" value="bank"> Bank Transfer</label>
            </fieldset>

            <div class="payment-method credit">
                <label>Card Number
                <input type="text" name="cc_number" placeholder="1234 5678 9012 3456">
                </label>
                <label>Expiry
                <input type="text" name="cc_expiry" placeholder="MM/YY">
                </label>
                <label>CVC
                <input type="text" name="cc_cvc" placeholder="123">
                </label>
            </div>

            <div class="payment-method paypal">
                <label>PayPal Email
                <input type="email" name="paypal_email" placeholder="email@example.com">
                </label>
            </div>

            <div class="payment-method bank">
                <label>IBAN
                <input type="text" name="iban" placeholder="DE00 0000 0000 0000 0000 00">
                </label>
            </div>

            <button type="submit">Send Request</button>
            </form>
    <?php }


?>