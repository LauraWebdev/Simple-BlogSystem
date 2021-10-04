<?php
    class Database {
        public $connection;

        function __construct() {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $this->connection = new mysqli("localhost", "root", "root", "sbs");

            if($this->connection->connect_errno) {
                throw new RuntimeException('[Database] Error connecting to Database: ' . $this->connection->connect_error);
            }

            return $this->connection;
        }

        function saveUser( $user ) {
            $username = $user->getUsername();
            $password = $user->getPassword();
            $publicName = $user->getPublicName();

            $saveStatement = $this->connection->prepare("INSERT INTO `users` (`username`, `password`, `publicName`) VALUES (?, ?, ?);");
            $saveStatement->bind_param("sss", $username, $password, $publicName);

            try {
                $saveStatement->execute();
                return "USER_CREATED";
            } catch(\Exception $e) {
                if($e->getCode() == 1062) {
                    return "DUPLICATE_USER";
                } else {
                    return "MYSQL_ERROR";
                }
            }
        }

        function saveBlogpost( $blogpost ) {
            $title = $blogpost->getTitle();
            $authorID = $blogpost->getAuthorID();
            $text = $blogpost->getText();
            $createdDate = $blogpost->getCreatedDate();

            $saveStatement = $this->connection->prepare("INSERT INTO `blogposts` (`title`, `authorID`, `text`, `createdDate`) VALUES (?, ?, ?, ?);");
            $saveStatement->bind_param("sisi", $title, $authorID, $text, $createdDate);

            try {
                $saveStatement->execute();
                return "BLOGPOST_CREATED";
            } catch(\Exception $e) {
                return "MYSQL_ERROR";
            }
        }

        function getBlogposts( $page ) {
            $pageOffset = $page * 5;

            // Gather Blogposts from DB
            $findBlogpostsStatement = $this->connection->prepare("SELECT * FROM `blogposts` ORDER BY `createdDate` DESC LIMIT 5 OFFSET ?");
            $findBlogpostsStatement->bind_param("i", $pageOffset);
            $findBlogpostsStatement->execute();
            $findBlogpostsResult = $findBlogpostsStatement->get_result();
            $findBlogpostsArray = $findBlogpostsResult->fetch_all(MYSQLI_ASSOC);

            // Parse raw assoc array to Blogpost objects
            $blogposts = [];
            foreach($findBlogpostsArray as $rawBlogpost) {
                $newBlogpost = new Blogpost();
                $newBlogpost->parse($rawBlogpost);

                $blogposts[] = $newBlogpost;
            }

            return $blogposts;
        }

        function getBlogpostCount() {
            $blogpostCountResult = $this->connection->query("SELECT count(*) FROM `blogposts`");
            $blogpostCount = $blogpostCountResult->fetch_array();

            return $blogpostCount[0];
        }

        function getBlogpost( $id ) {
            // Gather Blogpost from DB
            $findBlogpostStatement = $this->connection->prepare("SELECT * FROM `blogposts` WHERE `id` LIKE ?");
            $findBlogpostStatement->bind_param("i", $id);
            $findBlogpostStatement->execute();
            $findBlogpostResult = $findBlogpostStatement->get_result();
            $findBlogpostAssoc = $findBlogpostResult->fetch_assoc();

            // Parse to Blogpost object
            $blogpost = new Blogpost();
            $blogpost->parse($findBlogpostAssoc);

            return $blogpost;
        }

        function getUser( $id ) {
            // Gather User from DB
            $findUserStatement = $this->connection->prepare("SELECT * FROM `users` WHERE `id` LIKE ?");
            $findUserStatement->bind_param("i", $id);
            $findUserStatement->execute();
            $findUserResult = $findUserStatement->get_result();
            $findUserAssoc = $findUserResult->fetch_assoc();

            // Parse to User object
            $user = new User();
            $user->parse($findUserAssoc);

            return $user;
        }

        function removeBlogpost( $id ) {
            // Remove Blogpost from DB
            $removeBlogpostStatement = $this->connection->prepare("DELETE FROM `blogposts` WHERE `id` LIKE ?");
            $removeBlogpostStatement->bind_param("i", $id);

            try {
                $removeBlogpostStatement->execute();
                return true;
            } catch(\Exception $e) {
                return false;
            }
        }
    }
?>