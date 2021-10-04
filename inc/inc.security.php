<?php
    require_once('class.user.php');

    class Security {
        public $db;

        function __construct($db) {
            $this->db = $db;
            
            session_start();
        }

        function isAuthenticated() {
            if(!isset($_SESSION['sbsUser'])) return false;

            return true;
        }

        function getUser() {
            if(!isset($_SESSION['sbsUser'])) return false;

            return $_SESSION['sbsUser'];
        }

        function createUser($username, $password, $publicName) {
            if(!isset($username) || !isset($password) || !isset($publicName)) return false;

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $newUser = new User();
            $newUser->setUsername($username);
            $newUser->setPassword($hashedPassword);
            $newUser->setPublicName($publicName);

            return $this->db->saveUser($newUser);
        }

        function loginUser($username, $password) {
            if(!isset($username) || !isset($password)) return false;

            $findUserStatement = $this->db->connection->prepare("SELECT * FROM `users` WHERE `username` LIKE ?");
            $findUserStatement->bind_param("s", $username);
            $findUserStatement->execute();
            $findUserResult = $findUserStatement->get_result();
            $findUserAssoc = $findUserResult->fetch_assoc();

            // No user found
            if(!$findUserAssoc) {
                return "USER_NOT_FOUND";
            }

            if(!password_verify($password, $findUserAssoc['password'])) {
                return "USER_PASSWORD_WRONG";
            }

            $user = new User();
            $user->parse($findUserAssoc);
            $_SESSION['sbsUser'] = $user;

            return "USER_LOGGEDIN";
        }
    }
?>