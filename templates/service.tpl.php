<?php 

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');

    

    function drawService($service) {
        ?>
    
        <section id="title">
            <h1><?= $service->name ?></h1>
         </section>
         <section id="serviceDisplay">
                  <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300">
                  <h3> <a href="artist.php?id=<?= htmlspecialchars((string)$service->artistId) ?>"> <?= htmlspecialchars($service->artistName) ?> </a> </h3>
                  <div class="info">
                    <h3> Description: </h3>
                    <p> <?= htmlspecialchars($service->name) ?></p>
                    <p> <?= htmlspecialchars($service->description) ?></p>
                    <p class="price"> <?= htmlspecialchars((string)$service->cost) ?></p>
                    <p class="rating"> <?= htmlspecialchars((string)$service->rating) ?> </p>
                    <p class="waiting"> <?= htmlspecialchars((string)$service->avgTime) ?> </p>
                    <p class="requests"> Times requested: <?= htmlspecialchars((string)$service->requests) ?> </p>
                  </div>
                  <a href="request.php?id=<?=$service->id?>"><button> Request this service </button></a>
        </section>
    <?php }

    function drawServicesByCategory($services,string $category) { ?>
        <header id="popular_header"><h3> <?= $category?> Services: </h3>
                <div class=search-container>
                <i class="fas fa-search search-icon"></i>
                <input id="searchservice" type="text" placeholder="Search for any service...">
                </div>
                Max. price: <input id="searchprice" type="number"  placeholder="Max price">
                Min. rating: <input id="searchrating" type="number" min="0" max="5" step="0.1" placeholder="Min rating">
            </header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li id="service"> <a class="serviceInfo" href="service.php?id=<?= $service->id?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="<?= $service->image?>" alt="Service Image" width="300" height="250">
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

    function drawServices($services) { ?>
        <header id="popular_header"><h3> Services: </h3>
                <div class=search-container>
                <i class="fas fa-search search-icon"></i>
                <input id="searchservice" type="text" placeholder="Search for any service...">
                </div>
                Max. price: <input id="searchprice" type="number"  placeholder="Max price">
                Min. rating: <input id="searchrating" type="number" min="0" max="5" step="0.1" placeholder="Min rating">
                </header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li id="service"> <a class="serviceInfo" href="service.php?id=<?= $service->id?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="<?= $service->image?>" alt="Service Image" width="300" height="250">
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