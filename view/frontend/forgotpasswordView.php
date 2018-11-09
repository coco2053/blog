<?php

$title = 'Mot de passe oublié';

ob_start();
?>

<div class="formstyle">
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6 center">
            <h1 class="my-3"> <?= $title ?> </h1>

            <!-- Formulaire de reinitialisation du mot de passe -->
            <form id = 'form_reset' method = "post" action = "redefinir-mot-de-passe">
                <div class="form-group">
                    <label>Adresse email</label>
                    <input type="email" class="form-control" name="email" placeholder="Entrez votre adresse email" required />
                </div>

                <div class="g-recaptcha" data-sitekey="6LeF904UAAAAABO6m7Sl-pxLDJMS-2E6v1qzSdUP"></div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>


                Pas encore inscrit ?
            <p>
                <a class="btn btn-primary" href='inscription'>S'inscrire</a>
            </p>
        </div>
        <div class="col-md-3"> </div>
    </div>
</div>

<?php $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
