<?php


    declare(strict_types = 1);

    require_once('database.db.php');

    class Service{
        public int $id;
        public float $cost;
        public String $image;
        public String $artistId;
        public String $artistName;
        public String $name;
        public float $rating;
        public String $category;
        public int $requests;
        public String $description;
        public float $avgTime;

        public function __construct(
            int $id,
            float $cost,
            string $image,
            string $artistId,
            string $artistName,
            string $name,
            float $rating,
            string $category,
            int $requests,
            string $description,
            float $avgTime
        ) {
            $this->id = $id;
            $this->cost = $cost;
            $this->image = $image;
            $this->artistId = $artistId;
            $this->artistName = $artistName;
            $this->name = $name;
            $this->rating = $rating;
            $this->category = $category;
            $this->requests = $requests;
            $this->description = $description;
            $this->avgTime = $avgTime;
        }

        function getServices(int $num){
            $db = getDatabase();
            $stmt = $db->prepare()

            
        }

    }



?>