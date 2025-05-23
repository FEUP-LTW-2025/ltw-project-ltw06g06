<?php
    declare(strict_types = 1);

    function drawLoginForm() { ?>
        <form id='login' action="../actions/action_login.php" method='post'>
            <h3>Name:</h3>
            <input type="text" name="username" placeholder="Enter your name">

            <h3>Password:</h3>
            <input type="password" name="password" placeholder="Enter your password">

            <br><br>
            <button onclick="window.location.href='home.html'">Login</button>
            <h3> If you don't have an account :</h3>
            <a href="register.php"> Register </a>
        </form>
    <?php } 
    function drawRegisterForm(){?> 
        <form id='login' action="../actions/action_register.php" method='post'>
            <h3>Name:</h3>
            <input type="text" name="name" placeholder="Enter your first and last name">

            <h3>Username:</h3>
            <input type="text" name="username" placeholder="Choose your name">

            <h3>Email:</h3>
            <input type="email" name="email" placeholder="Enter your email">
            
            <h3>Password:</h3>
            <input type="password" name="password" placeholder="Choose your password">

            <br><br>
            <button type='submit'>Register</button>
        </form>
    <?php }
?>