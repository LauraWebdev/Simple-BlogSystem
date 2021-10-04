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
            <li class="navbar-text">
                Willkommen, <?=$security->getUser()->getPublicName();?>
            </li>
            <li class="nav-item <?= $currentPage == "createblogpost" ? 'active' : ''; ?>">
                <a class="nav-link" href="createblogpost.php">Neuer Beitrag</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>