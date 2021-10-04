<?php
    class User {
        public $id;
        public $username;
        public $password;
        public $publicName;

        function getID() {
            return $this->id;
        }
        function getUsername() {
            return $this->username;
        }
        function getPassword() {
            return $this->password;
        }
        function getPublicName() {
            return $this->publicName;
        }

        function setID($id) {
            $this->id = $id;
        }
        function setUsername($username) {
            $this->username = $username;
        }
        function setPassword($password) {
            $this->password = $password;
        }
        function setPublicName($publicName) {
            $this->publicName = $publicName;
        }

        function parse( $assocUser ) {
            $this->id = $assocUser['id'];
            $this->username = $assocUser['username'];
            $this->password = $assocUser['password'];
            $this->publicName = $assocUser['publicName'];

            return $this;
        }
    }
?>