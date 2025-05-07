<?php 

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');

    

    function drawService($service) {?>
        <section id="title">
            <h1><?= $service->name ?></h1>
         </section>

         <section id="serviceDisplay">
                  <img src="example.jpg" alt="Service Image" width="300">
                  <h3> <a href="artist.php?id=<?= $service->artistId ?>"> <?= $service->artistName ?> </a> </h3>
                  <div class="info">
                    <h3> Description: </h3>
                    <p> <?= $service->name ?></p>
                    <p> <?= $service->description ?></p>
                    <p class="price"> <?= $service->cost ?></p>
                    <p class="rating"> <?= $service->rating ?> </p>
                    <p class="waiting"> <?= $service->avgTime ?> </p>
                  </div>
                  <a href="index.php"><button> Request this service </button></a>
        </section>
    <?php }

    function drawServicesByCategory($services,string $category) { ?>
        <header id="popular_header"><h3> <?= $category?> Services: </h3></header>
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
    <?php 
    }

?>