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
    }


?>