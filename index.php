<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    $currentPage = "index";

    include_once('template/tpl.page.header.php');
    
    if($security->isAuthenticated()) {
        include_once('template/tpl.page.navigationAuthenticated.php');
    } else {
        include_once('template/tpl.page.navigationBasic.php');
    }

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
    $blogposts = $db->getBlogposts($currentPage);
    $blogpostCount = $db->getBlogpostCount();
?>
    <div class="container px-4 py-4">
        <div class="row">
            <div class="col-md-12">
                <h4>Blogeinträge</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <?php
                    foreach($blogposts as $blogpost) {
                        $author = $db->getUser( $blogpost->getAuthorID() );

                        ?>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Erstellt von <?=$author->getPublicName();?> am <?=date("d.m.Y - H:i", $blogpost->getCreatedDate());?></h6>
                                    <h5 class="card-title"><?=$blogpost->getTitle();?></h5>
                                    <p class="card-text"><?=mb_strimwidth($blogpost->getText(), 0, 250, "..."); ?></p>
                                    <a href="blogpost.php?id=<?=$blogpost->getID();?>" class="btn btn-primary">Lesen</a>
                                    <?php if ($security->isAuthenticated() && $author->getID() === $security->getUser()->getID()) { ?><a href="removeblogpost.php?id=<?=$blogpost->getID();?>" onclick="return confirm('Möchten Sie diesen Eintrag wirklich löschen?');" class="btn btn-danger">Löschen</a><?php } ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <?php
                    if($currentPage > 0) {
                        ?>
                            <a href="index.php?page=<?=$currentPage - 1;?>" class="btn btn-secondary">Vorherige Seite</a>
                        <?php
                    }
                ?>
            </div>
            <div class="col-md-4 mt-3 d-flex align-items-center justify-content-center">
                <span class="text-muted">Seite <?=$currentPage + 1;?> / <?=ceil($blogpostCount / 5);?></span>
            </div>
            <div class="col-md-4 mt-3">
                <?php
                    if(($currentPage + 1) * 5 < $blogpostCount) {
                        ?>
                            <a href="index.php?page=<?=$currentPage + 1;?>" class="btn btn-secondary float-right">Nächste Seite</a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
<?php

    include_once('template/tpl.page.footer.php');
?>