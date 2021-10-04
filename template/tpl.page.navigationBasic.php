<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?= $currentPage == "index" ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">Startseite</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item <?= $currentPage == "login" ? 'active' : ''; ?>">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item <?= $currentPage == "register" ? 'active' : ''; ?>">
                <a class="nav-link" href="register.php">Registrieren</a>
            </li>
        </ul>
    </div>
</nav>