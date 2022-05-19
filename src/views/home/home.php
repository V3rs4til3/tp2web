<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-white border-bottom fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link display-4" aria-current="page" href="<?= HOME_PATH ?>/home/index" >StockM</a>
                    </li>
                </ul>
            </div>

                <?php if (isset($_SESSION['user'])) { ?>
            <div class="col-md-3 text-end">
                    <a class="pr-4" href="<?= HOME_PATH ?>/market/sell">Vendre</a>
                    <a class="pr-4" href="<?= HOME_PATH ?>/market/buy">Mes achats</a>
                    <a class="pr-4" href="<?= HOME_PATH ?>/user/mdp">Mot de pass</a>
                    <a class="btn btn-primary" href="<?= HOME_PATH ?>/user/Disconnect">Déconnexion</a>
                <?php } else { ?>
                <div class="col-md-2 text-end">
                    <a class="btn btn-primary" href="<?= HOME_PATH ?>/User/ViewConnect" role="button">Connexion</a>
                    <a class="btn btn-primary" href="<?= HOME_PATH ?>/User/ViewCreate" role="button">Creer</a>
                <?php } ?>
            </div>

        </div>
    </nav>
    <!-- Navbar -->
</header>

<body>
<!-- Background image -->

<!-- Background image -->
</body>