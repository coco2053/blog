

<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $title ?></title>

        <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/css/1-col-portfolio.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
          <div class="container">
            <a class="navbar-brand" href="#">Bastien Vacherand</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Accueil
                    <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Articles</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Cv</a>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
              <li>
                <div class="inset">
                  <?php
                  if(!empty($_SESSION['user'])) {
                    ?>
                  <a href='?action=getUser&id=<?=htmlspecialchars($_SESSION['user']->id_user())?>'> <img src="public/img/profile.png"></a>
                  <?php
                }
                ?>
                </div>
              </li>
            </ul>
            </div>
          </div>
        </nav>

        <!-- Page Content -->
        <div class="container">

        <?php
         if(!empty($_SESSION['user'])) {

            if(strpos($_SESSION['user'] -> perm_action(), 'writePostView') !== false) {
        ?>
          <p>
          <a class="btn btn-primary" href='?action=addPostView'>Ecrire un article</a>
          </p>
        <?php
          }
        }
        ?>

          <!-- Page Heading -->
          <h1 class="my-4"><?= $title ?>
            <!-- <small><?= $description ?></small> -->
          </h1>


          <?= $content ?>

          <!-- Pagination -->
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précedent</span>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Suivant</span>
              </a>
            </li>
          </ul>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="py-2 bg-dark fixed-bottom">
          <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Tondo Design 2018</p>

            <?php if(!isset($_SESSION['user'])) {

            ?>
                   <p> <a class="btn text-center btn-primary" href='?action=signInView'>Se connecter</a>
            <?php
                } else {
            ?>

                   <p> <a class="btn text-center btn-primary" href='?action=signOut'>Se déconnecter</a>
            <?php
                }
            ?>

          </div>
          <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
