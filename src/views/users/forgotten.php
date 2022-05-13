<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-white border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link display-4" aria-current="page" href="<?= HOME_PATH ?>/home/index" >StockM</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-2 text-end">
                <a class="btn btn-primary" href="<?= HOME_PATH ?>/User/ViewConnect" role="button">Connexion</a>
                <a class="btn btn-primary" href="<?= HOME_PATH ?>/User/ViewCreate" role="button">Creer</a>
            </div>

        </div>
    </nav>
    <!-- Navbar -->
</header>

<body>
<div class="container">
    <form method="post">

        <?php if(isset($_POST['error'])){  ?>
            <div class="alert alert-danger m-4" role="alert">
                <?= $_POST['error'] ?>
            </div>
        <?php } else if(isset($_POST['success'])){ ?>
            <div class="alert alert-success m-4" role="alert">
                <?= $_POST['success'] ?>
            </div>
        <?php }?>

        <div class="m-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email"/>
        </div>
        <div class="m-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
</div>
</body>