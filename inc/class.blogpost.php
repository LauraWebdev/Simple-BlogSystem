<?php
    class Blogpost {
        public $id;
        public $title;
        public $authorID;
        public $text;
        public $createdDate;

        function getID() {
            return $this->id;
        }
        function getTitle() {
            return $this->title;
        }
        function getAuthorID() {
            return $this->authorID;
        }
        function getText() {
            return $this->text;
        }
        function getCreatedDate() {
            return $this->createdDate;
        }

        function setID($id) {
            $this->id = $id;
        }
        function setTitle($title) {
            $this->title = $title;
        }
        function setAuthorID($authorID) {
            $this->authorID = $authorID;
        }
        function setText($text) {
            $this->text = $text;
        }
        function setCreatedDate($createdDate) {
            $this->createdDate = $createdDate;
        }

        function parse( $assocBlogpost ) {
            $this->id = $assocBlogpost['id'];
            $this->title = $assocBlogpost['title'];
            $this->authorID = $assocBlogpost['authorID'];
            $this->text = $assocBlogpost['text'];
            $this->createdDate = $assocBlogpost['createdDate'];
        }
    }
?>