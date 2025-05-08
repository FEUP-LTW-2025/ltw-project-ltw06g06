<?php


    declare(strict_types = 1);

    require_once('database.db.php');

    class Service{
        public int $id;
        public float $cost;
        public String $image;
        public int $artistId;
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
            int $artistId,
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

        static function getTopServices(int $num){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT *, S.rating as Srating FROM Service S JOIN Artist A ON A.artistId = S.artistId JOIN Users U ON U.id = A.artistId ORDER BY rating DESC LIMIT ?');
            $stmt->bindParam(1,$num);
            $stmt->execute();
            $services = $stmt->fetchAll();
            $res = array();
            foreach($services as $service){
                $res[] = new Service(
                    $service['serviceId'],
                    $service['cost'],
                    $service['image'] = 'example.jpg',
                    $service['artistId'],
                    $service['username'],
                    $service['serviceName'],
                    $service['Srating'],
                    $service['category'],
                    $service['requests'],
                    $service['description'],
                    $service['avgTime']
                );
            }
            return $res;
        }

        static function getServiceById(int $id){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT *,S.description as Sdescription, S.rating as Srating FROM Service S JOIN Artist A ON A.artistId = S.artistId JOIN Users U ON U.id = A.artistId WHERE S.serviceId = ?');
            $stmt->bindParam(1,$id);
            $stmt->execute();
            $service = $stmt->fetch();
            return new Service(
                    $service['serviceId'],
                    $service['cost'],
                    $service['image'] = 'example.jpg',
                    $service['artistId'],
                    $service['username'],
                    $service['serviceName'],
                    $service['Srating'],
                    $service['category'],
                    $service['requests'],
                    $service['Sdescription'],
                    $service['avgTime']
                );
            }

    static function getServicesByCategory(string $category){
                $db = getDatabase();
                $stmt = $db->prepare('SELECT *, S.rating as Srating FROM Service S JOIN Artist A ON A.artistId = S.artistId JOIN Users U ON U.id = A.artistId WHERE S.category = ? ORDER BY rating DESC');
                $stmt->bindParam(1,$category);
                $stmt->execute();
                $services = $stmt->fetchAll();
                $res = array();
                var_dump($service['Srating']);
                foreach($services as $service){
                    $res[] = new Service(
                        $service['serviceId'],
                        $service['cost'],
                        $service['image'] = 'example.jpg',
                        $service['artistId'],
                        $service['username'],
                        $service['serviceName'],
                        $service['Srating'],
                        $service['category'],
                        $service['requests'],
                        $service['description'],
                        $service['avgTime']
                    );
                }
                return $res;
            }
    }



?>