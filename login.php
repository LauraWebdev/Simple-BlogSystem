<?php
    require_once('inc/inc.db.php');
    require_once('inc/inc.security.php');
    
    require_once('inc/class.user.php');
    require_once('inc/class.blogpost.php');

    $db = new Database();
    $security = new Security($db);

    $currentPage = "login";

    // Redirect if already logged in
    if($security->isAuthenticated()) {
        header("Location: index.php");
    }

    // Handle Login
    $loginResult = null;
    if(isset($_POST['loginSubmit'])) {
        $loginResult = $security->loginUser($_POST['loginUsername'], $_POST['loginPassword']);

        if($loginResult === "USER_LOGGEDIN") {
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
                <h4>Login</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 py-3">
                <?php
                    if($loginResult === "USER_PASSWORD_WRONG") {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Username oder Password sind nicht korrekt.
                    </div>
                <?php
                    } else if($loginResult === "USER_NOT_FOUND") {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Dieser Username existiert nicht.
                    </div>
                <?php
                    }
                ?>

                <form method="post" action="" class="pt-2">
                    <div class="form-group">
                        <label for="loginUsername">Username</label>
                        <input type="text" class="form-control" name="loginUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Passwort</label>
                        <input type="password" class="form-control" name="loginPassword" required>
                    </div>
                    <button type="submit" name="loginSubmit" class="btn btn-primary float-right">Login</button>
                </form>
            </div>
        </div>
    </div>
<?php

    include_once('template/tpl.page.footer.php');
?>