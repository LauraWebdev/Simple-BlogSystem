<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    // Redirect if not logged in
    if(!$security->isAuthenticated()) {
        header("Location: index.php");
    }

    if(!isset($_GET['id'])) {
        header("Location: index.php");
    }

    $blogpost = $db->getBlogpost($_GET['id']);
    
    if($blogpost->getAuthorID() !== $security->getUser()->getID()) {
        header("Location: index.php");
    }

    $db->removeBlogpost($blogpost->getID());

    header("Location: index.php");
?>