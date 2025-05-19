<?php

    declare(strict_types = 1);

    require_once('database.db.php');

    class User{

        public int $id;
        public string $name;
        public string $username;
        public string $email;
        public string $password;
        public string $pfp;


        public function __construct(int $id, string $name,string $username, string $email, string $password, string $pfp) {
            $this->id = $id;
            $this->name = $name;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->pfp = $pfp;
        }
        
        
        static function getUser($username){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT * from Users WHERE Users.username = ?');
            $stmt->bindParam(1,$username);
            $stmt->execute();
            $user = $stmt->fetch();
            return new User(
                $user['id'],
                $user['fullname'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['profileP']
            );
        }

        static function getChatUsers($userId){
            $db = getDatabase();
            $stmt = $db->prepare('SELECT DISTINCT u.id, u.username, u.fullname, u.email, u.password, u.profileP
                        FROM Users u
                        JOIN (
                            -- Current user is artist, u is the client
                            SELECT r.clientId AS userId
                            FROM Request r
                            JOIN Service s ON r.serviceId = s.serviceId
                            WHERE s.artistId = ?
                            
                            UNION
                            
                            -- Current user is client, u is the artist
                            SELECT s.artistId AS userId
                            FROM Request r
                            JOIN Service s ON r.serviceId = s.serviceId
                            WHERE r.clientId = ?
                        ) AS rel ON u.id = rel.userId
                        WHERE u.id != ?
                        ');

            $stmt->execute([$userId,$userId,$userId]);
            $users = $stmt->fetchAll();
            $res = array();
            foreach ($users as $user) {
            $res[] = new User(
                $user['id'],
                $user['fullname'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['profileP']
            );
         
            }
            return $res;

        }
    }


?>