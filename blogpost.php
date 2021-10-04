<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    $currentPage = "blogpost";

    include_once('template/tpl.page.header.php');
    
    if($security->isAuthenticated()) {
        include_once('template/tpl.page.navigationAuthenticated.php');
    } else {
        include_once('template/tpl.page.navigationBasic.php');
    }

    if(!isset($_GET['id'])) {
        header("Location: index.php");
    }

    $blogpost = $db->getBlogpost($_GET['id']);
    $author = $db->getUser($blogpost->getAuthorID());
?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h6 class="mb-2 text-muted">Erstellt von <?=$author->getPublicName();?> am <?=date("d.m.Y - H:i", $blogpost->getCreatedDate());?></h6>
                <h5><?=$blogpost->getTitle(); ?></h5>
                <p><?=nl2br($blogpost->getText()); ?></p>
                <?php if ($security->isAuthenticated() && $author->getID() === $security->getUser()->getID()) { ?>
                    <hr />
                    <a href="removeblogpost.php?id=<?=$blogpost->getID();?>" onclick="return confirm('Möchten Sie diesen Eintrag wirklich löschen?');" class="btn btn-danger">Löschen</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php

    include_once('template/tpl.page.footer.php');
?>