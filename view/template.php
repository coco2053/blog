
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
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                        aria-label="Toggle navigation">
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
                            <a class="nav-link" href="articles">Articles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact">Contact</a>
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
                                    <a href='profile-<?=htmlspecialchars($_SESSION['user']->id_user())?>'>
                                        <img src="public/img/profile.png">
                                    </a>
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

            <!-- Modal -->
            <div class="modal fade" id="centralModalSm" tabindex="-1"
                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                        }
                        ?>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if(!empty($_SESSION['user'])) {
                if(strpos($_SESSION['user'] -> perm_action(), 'writePostView') !== false) {
                    ?>
                    <p>
                        <a class="btn btn-primary" href='redaction-article'>Ecrire un article</a>
                    </p>
                    <?php
                }
            }
            ?>
            <!-- Page Heading -->
            <h1 class="my-4"> <?= $title ?> </h1>
            <?= $content ?>

        </div>

        <!-- Footer -->
        <footer class="py-2 bg-dark fixed-bottom">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Tondo Design 2018</p>

                <?php
                if(!isset($_SESSION['user'])) {
                    ?>
                    <p> <a class="btn text-center btn-primary" href='connexion'>Se connecter </a>
                    <?php
                } else {
                    ?>
                    <p> <a class="btn text-center btn-primary" href='deconnexion'>Se déconnecter</a>
                    <?php
                }
                ?>

            </div>
          <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="public/vendor/jquery/jquery.min.js"></script>
        <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <?php
        if(isset($_SESSION['show_message'])) {
            if($_SESSION['show_message']) {
                $_SESSION['show_message'] = false;
                ?>
                <script type="text/javascript">
                    $('#centralModalSm').modal({
                        show: true
                    })
                </script>
                <?php
            }
        }
        ?>

    </body>

</html>
