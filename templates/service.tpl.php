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
                    <p> <?= $service->description ?></p>
                    <p class="price"> <?= $service->cost ?></p>
                    <p class="rating"> <?= $service->rating ?> </p>
                    <p class="waiting"> <?= $service->avgTime ?> </p>
                  </div>
        </section>
    <?php }

?>