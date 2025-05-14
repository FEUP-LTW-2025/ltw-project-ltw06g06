<?php


    declare(strict_types = 1);

    require_once('database.db.php');

    class Request{
        public int $clientId;
        public int $serviceId;
        public String $request;
        public String $serviceDescription;
        public String $category;
        public String $date;
        public String $status;
        public String $artistName;
        public String $serviceImg;

       public function __construct(
            int $clientId,
            int $serviceId,
            string $request,
            string $serviceDescription,
            string $category,
            string $date,
            string $status,
            string $artistName,
            string $serviceImg
        ) {
            $this->clientId = $clientId;
            $this->serviceId = $serviceId;
            $this->request = $request;
            $this->serviceDescription = $serviceDescription;
            $this->category = $category;
            $this->date = $date;
            $this->status = $status;
            $this->artistName = $artistName;
            $this->serviceImg = $serviceImg;
        }

        static function getPendingRequestsFromUser(int $uId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT R.clientId, 
                                        R.serviceId, 
                                        R.description AS request, 
                                        S.description AS serviceDescription, 
                                        S.image AS serviceImg, 
                                        U.username AS artistName, 
                                        S.category, 
                                        R.date, 
                                        R.status 
                                        FROM Users U JOIN Client C ON C.clientId = U.Id JOIN Request R ON R.clientId = C.clientId JOIN Service S ON S.serviceId = R.serviceId JOIN Artist A ON A.artistId = S.artistId 
                                        WHERE U.id = ? AND R.status = "PENDING" ORDER BY R.date');
            $stmt->bindParam(1, $uId, PDO::PARAM_INT);
            $stmt->execute();
            $requests = $stmt->fetchAll();

            $res = [];
            foreach ($requests as $request) {
                $res[] = new Request(
                    $request['clientId'],
                    $request['serviceId'],
                    $request['request'],
                    $request['serviceDescription'],
                    $request['category'],
                    $request['date'],
                    $request['status'],
                    $request['artistName'],
                    $request['serviceImg']
                );
            }
            return $res;
        }


        static function getCompletedRequestsFromUser(int $uId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT R.clientId, 
                                        R.serviceId, 
                                        R.description AS request, 
                                        S.description AS serviceDescription, 
                                        S.image AS serviceImg, 
                                        A.name AS artistName, 
                                        R.category, 
                                        R.date, 
                                        R.status 
                                        FROM Users U JOIN Client C ON C.clientId = U.Id JOIN Request R ON R.clientId = C.clientId JOIN Service S ON S.serviceId = R.serviceId JOIN Artist A ON A.artistId = S.artistId 
                                        WHERE U.id = ? AND R.status = "COMPLETE" ORDER BY R.date');
            $stmt->bindParam(1, $uId, PDO::PARAM_INT);
            $stmt->execute();
            $requests = $stmt->fetchAll();

            $res = [];
            foreach ($requests as $request) {
                $res[] = new Request(
                    $request['clientId'],
                    $request['serviceId'],
                    $request['request'],
                    $request['serviceDescription'],
                    $request['category'],
                    $request['date'],
                    $request['status'],
                    $request['artistName'],
                    $request['serviceImg']
                );
            }
            return $res;
        }
    }



?>