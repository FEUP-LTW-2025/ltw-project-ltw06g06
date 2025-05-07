<?php


    declare(strict_types = 1);

    require_once('database.db.php');

    class Review{
        public int $clientId;
        public int $serviceId;
        public String $description;
        public String $date;
        public float $rating;
        public String $username;
        public String $userImg;

        public function __construct(
            int $clientId,
            int $serviceId,
            string $description,
            string $date,
            float $rating,
            string $username,
            string $userImg
        ) {
            $this->clientId = $clientId;
            $this->serviceId = $serviceId;
            $this->description = $description;
            $this->date = $date;
            $this->rating = $rating;
            $this->username = $username;
            $this->userImg = $userImg;
        }

        static function getAllReviewsFromService(int $sId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT * FROM Service S JOIN Review R ON R.serviceId = S.serviceId JOIN Client C ON C.clientId = R.clientId JOIN Users U ON C.clientId = U.id WHERE S.serviceId = ? ORDER BY rating');
            $stmt->bindParam(1,$sId);
            $stmt->execute();
            $reviews = $stmt->fetchAll();
            $res = array();
            foreach($reviews as $review){
                $res[] = new Review(
                    $review['clientId'],
                    $review['serviceId'],
                    $review['comment'],
                    $review['date'],
                    $review['rating'],
                    $review['username'],
                    $review['profileP'],
                );
            }
            return $res;
        }


    }



?>