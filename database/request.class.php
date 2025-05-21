<?php


    declare(strict_types = 1);

    require_once('database.db.php');

    class Request{
        public int $clientId;
        public int $serviceId;
        public int $artistId;
        public String $request;
        public String $serviceName;
        public String $serviceDescription;
        public String $category;
        public String $date;
        public String $status;
        public String $artistName;
        public String $clientName;
        public String $serviceImg;

       public function __construct(
            int $clientId,
            int $serviceId,
            int $artistId,
            string $request,
            string $serviceDescription,
            string $category,
            string $date,
            string $status,
            string $artistName,
            string $clientName,
            string $serviceImg,
            String $serviceName
        ) {
            $this->clientId = $clientId;
            $this->serviceId = $serviceId;
            $this->artistId = $artistId;
            $this->request = $request;
            $this->serviceDescription = $serviceDescription;
            $this->category = $category;
            $this->date = $date;
            $this->status = $status;
            $this->artistName = $artistName;
            $this->clientName = $clientName;
            $this->serviceImg = $serviceImg;
            $this->serviceName = $serviceName;

        }

        static function getPendingRequestsFromUser(int $uId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT R.clientId, 
                                        R.serviceId, 
                                        R.description AS request, 
                                        S.description AS serviceDescription, 
                                        S.image AS serviceImg, 
                                        U.username AS username,
                                        A.artistId AS artistId, 
                                        S.category, 
                                        R.date, 
                                        R.status,
                                        S.serviceName 
                                        FROM Users U JOIN Client C ON C.clientId = U.Id JOIN Request R ON R.clientId = C.clientId JOIN Service S ON S.serviceId = R.serviceId JOIN Artist A ON A.artistId = S.artistId 
                                        WHERE U.id = ? AND R.status = "PENDING" ORDER BY R.date');
            $stmt->bindParam(1, $uId, PDO::PARAM_INT);
            $stmt->execute();
            $requests = $stmt->fetchAll();
            $stmt = $db->prepare('SELECT username FROM USERS U JOIN ARTIST A ON U.id = A.artistId WHERE A.artistId = ?');
            $stmt->bindParam(1, $request['artistId'], PDO::PARAM_INT);
            $stmt->execute();
            $artist = $stmt->fetch();
            $res = [];
            foreach ($requests as $request) {
                $stmt = $db->prepare('SELECT username FROM USERS U JOIN ARTIST A ON U.id = A.artistId WHERE A.artistId = ?');
                $stmt->bindParam(1, $request['artistId'], PDO::PARAM_INT);
                $stmt->execute();
                $artist = $stmt->fetch();
                $res[] = new Request(
                    $request['clientId'],
                    $request['serviceId'],
                    $request['artistId'],
                    $request['request'],
                    $request['serviceDescription'],
                    $request['category'],
                    $request['date'],
                    $request['status'],
                    $artist['username'],
                    $request['username'],
                    $request['serviceImg'],
                    $request['serviceName']
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
                                        U.name AS username, 
                                        R.category, 
                                        R.date, 
                                        R.status,
                                        S.serviceName 
                                        FROM Users U JOIN Client C ON C.clientId = U.Id JOIN Request R ON R.clientId = C.clientId JOIN Service S ON S.serviceId = R.serviceId JOIN Artist A ON A.artistId = S.artistId 
                                        WHERE U.id = ? AND R.status = "COMPLETE" ORDER BY R.date');
            $stmt->bindParam(1, $uId, PDO::PARAM_INT);
            $stmt->execute();
            $requests = $stmt->fetchAll();
            $res = [];
            foreach ($requests as $request) {
                $stmt = $db->prepare('SELECT username FROM USERS U JOIN ARTIST A ON U.id = A.artistId WHERE A.artistId = ?');
                $stmt->bindParam(1, $request['artistId'], PDO::PARAM_INT);
                $stmt->execute();
                $artist = $stmt->fetch();
                $res[] = new Request(
                    $request['clientId'],
                    $request['serviceId'],
                    $request['request'],
                    $request['serviceDescription'],
                    $request['category'],
                    $request['date'],
                    $request['status'],
                    $artist['username'],
                    $request['username'],
                    $request['serviceImg'],
                    $request['serviceName']
                );
            }
            return $res;
        }


        static function getRequestsFromArtist(int $AId) {
            $db = getDatabase();
            $stmt = $db->prepare('
                SELECT R.clientId, 
                    R.serviceId, 
                    A.artistId,
                    R.description AS request, 
                    S.description AS serviceDescription, 
                    S.image AS serviceImg, 
                    U.username AS artistName,
                    S.category, 
                    R.date, 
                    R.status,
                    S.serviceName
                FROM Users U
                JOIN Artist A ON A.artistId = U.Id
                JOIN Service S ON S.artistId = A.artistId
                JOIN Request R ON R.serviceId = S.serviceId
                JOIN Client C ON C.clientId = R.clientId
                WHERE A.artistId = ? AND R.status = "PENDING"
                ORDER BY R.date
            ');
            $stmt->bindParam(1, $AId, PDO::PARAM_INT);
            $stmt->execute();
            $requests = $stmt->fetchAll();

            $res = [];
            foreach ($requests as $request) {
                $stmt = $db->prepare('SELECT username FROM USERS U JOIN Client C ON U.id = C.clientId WHERE C.clientId = ?');
                $stmt->bindParam(1, $request['clientId'], PDO::PARAM_INT);
                $stmt->execute();
                $client = $stmt->fetch();
                $res[] = new Request(
                    $request['clientId'],
                    $request['serviceId'],
                    $request['artistId'],
                    $request['request'],
                    $request['serviceDescription'],
                    $request['category'],
                    $request['date'],
                    $request['status'],
                    $request['artistName'],
                    $client['username'],
                    $request['serviceImg'],
                    $request['serviceName']
                );
            }
            return $res;
        }

        static function getCustomRequestsFromArtist(PDO $db,int $Aid){
            $stmt = $db->prepare('SELECT
                                        CU.Cname,
                                        CU.clientId,
                                        CU.CserviceId,
                                        CU.artistId,
                                        CU.description AS serviceDescription,
                                        CU.date,
                                        CU.status,
                                        CU.image AS Simage,
                                        U.username
                                        FROM CustomService CU
                                        JOIN Artist A ON CU.artistId = A.artistId
                                        JOIN Users U ON U.id = CU.clientId
                                        WHERE A.artistId = ?');
            $stmt->execute([$Aid]);
            $cr = $stmt->fetchAll();
            $res = array();
            foreach($cr as $request){
                $res[] = new Request(
                    $request['clientId'],
                    $request['CserviceId'],
                    $request['artistId'],
                    "",
                    $request['serviceDescription'],
                    "",
                    $request['date'],
                    $request['status'],
                    "",
                    $request['username'],
                    $request['Simage'],
                    $request['Cname']
                );
            }
            return $res;
        }
    }



?>