<?php

    declare(strict_types = 1);

    require_once('database.db.php');

    class Artist{

        public int $artistId;
        public string $name;
        public string $username;
        public string $email;
        public string $category;
        public float $rating;
        public string $description;
        public int $services;
        public string $pfp;

        public function __construct(int $artistId, string $name,string $username, string $email, string $category, float $rating, string $description, int $services, string $pfp) {
            $this->artistId = $artistId;
            $this->name = $name;
            $this->username = $username;
            $this->email = $email;
            $this->category = $category;
            $this->rating = $rating;
            $this->description = $description;
            $this->services = $services;
            $this->pfp = $pfp;
        }
        static function getArtist($aId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT *, A.rating as Arating ,COUNT(S.serviceId) as services, A.description as Adesc from Artist A JOIN Service S ON A.artistId = S.artistId JOIN Users U ON U.id = A.artistId WHERE A.artistId = ?');
            $stmt->bindParam(1,$aId);
            $stmt->execute();
            $artist = $stmt->fetch();
            return new Artist(
                $artist['artistId'],
                $artist['fullname'],
                $artist['username'],
                $artist['email'],
                $artist['category'],
                $artist['Arating'],
                $artist['Adesc'],
                $artist['services'],
                $artist['profileP']
            );
        }
    }


?>