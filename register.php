<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    $currentPage = "register";

    // Redirect if already logged in
    if($security->isAuthenticated()) {
        header("Location: index.php");
    }

    // Handle Form Input
    $registerResult = null;
    if(isset($_POST['registerSubmit'])) {
        if($_POST['registerPassword'] != $_POST['registerPasswordTwo']) {
            $registerResult = false;
        } else {
            $registerResult = $security->createUser($_POST['registerUsername'], $_POST['registerPassword'], $_POST['registerPublicName']);

            if($registerResult === "USER_CREATED") {
                header("Location: login.php");
            }
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
                <h4>Registrieren</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 py-3">
                <?php
                    if($registerResult === "DUPLICATE_USER") {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Dieser Username ist bereits vergeben.
                    </div>
                <?php
                    } elseif($registerResult === "MYSQL_ERROR") {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Etwas lief schief. Bitte versuchen Sie es später erneut.
                    </div>
                <?php
                    }
                ?>

                <form method="post" action="" class="pt-2">
                    <div class="form-group">
                        <label for="registerUsername">Username</label>
                        <input type="text" class="form-control" name="registerUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Passwort</label>
                        <input type="password" class="form-control" name="registerPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPasswordTwo">Passwort (wiederholen)</label>
                        <input type="password" class="form-control" name="registerPasswordTwo" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPublicName">Öffentlicher Name</label>
                        <input type="text" class="form-control" name="registerPublicName" required>
                    </div>
                    <button type="submit" name="registerSubmit" class="btn btn-primary float-right">Registrieren</button>
                </form>
            </div>
        </div>
    </div>
<?php

    include_once('template/tpl.page.footer.php');
?>