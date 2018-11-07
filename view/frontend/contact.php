<?php

$title = 'Contact';

ob_start();
?>

<div class="formulaires">
    <h1 class="my-3"> <?= $title ?> </h1>

    <!-- Formulaire de connexion -->
    <form id = 'form_ins' method = "post" action = "contacter">
        <div class="form-group">
            <label>Nom </label>
            <input type="text" class="form-control" name="lastname" placeholder="Entrez votre nom" required />
            <label>Prénom </label>
            <input type="text" class="form-control" name="firstname" placeholder="Entrez votre prénom" required />
            <label>Adresse email </label>
            <input type="email" class="form-control" name="email" placeholder="Entrez votre adresse email" required />
            <label>Laisser votre message :</label>
            <textarea class="form-control" name="message" id="message" rows="4" cols="40" required ></textarea> </br>
            <div class="g-recaptcha"
                 data-sitekey="6LeF904UAAAAABO6m7Sl-pxLDJMS-2E6v1qzSdUP"></div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
</div>

<?php $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
