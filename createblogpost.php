<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    $currentPage = "createblogpost";

    // Redirect if not logged in
    if(!$security->isAuthenticated()) {
        header("Location: index.php");
    }

    // Handle Submit
    $blogpostResult = null;
    if(isset($_POST['blogpostSave'])) {
        $newBlogpost = new Blogpost();
        $newBlogpost->setTitle($_POST['blogpostTitle']);
        $newBlogpost->setAuthorID($security->getUser()->getID());
        $newBlogpost->setText( htmlspecialchars($_POST['blogpostText']) );
        $newBlogpost->setCreatedDate(time());

        $blogpostResult = $db->saveBlogpost($newBlogpost);

        if($blogpostResult === "BLOGPOST_CREATED") {
            header("Location: index.php");
        }
    }

    include_once('template/tpl.page.header.php');
    
    if($security->isAuthenticated()) {
        include_once('template/tpl.page.navigationAuthenticated.php');
    } else {
        include_once('template/tpl.page.navigationBasic.php');
    }
?>
<div class="container px-4 py-4">
    <div class="row">
        <div class="col-md-12">
            <h4>Neuer Beitrag</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2 py-3">
            <?php
                if($blogpostResult !== "BLOGPOST_CREATED" && $blogpostResult !== null) {
            ?>
                <div class="alert alert-danger" role="alert">
                    Beitrag konnte nicht angelegt werden.
                </div>
            <?php
                }
            ?>

            <form method="post" action="" class="pt-2">
                <div class="form-group">
                    <label for="blogpostTitle">Titel</label>
                    <input type="text" class="form-control" name="blogpostTitle" required>
                </div>
                <div class="form-group">
                    <label for="blogpostText">Text</label>
                    <textarea class="form-control" name="blogpostText" required rows="8"></textarea>
                </div>
                <button type="submit" name="blogpostSave" class="btn btn-primary float-right">Speichern</button>
            </form>
        </div>
    </div>
</div>
<?php

    include_once('template/tpl.page.footer.php');
?>