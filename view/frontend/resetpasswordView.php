<?php

$title = 'Réinitialiser votre mot de passe';

ob_start();
?>

<div class="formstyle">
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6 center">
            <h1 class="my-3"> <?= $title ?> </h1>

            <!-- Formulaire de redefinition du mot de passe -->
            <form id = 'form_pass-change' method = "post" action = "valider-mot-de-passe">
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" class="form-control" name="password"
                           placeholder="Entrez votre nouveau mot de passe" required />
                    <label>Entrez à nouveau votre mot de passe</label>
                    <input type="password" class="form-control" name="passwordbis"
                           placeholder="Retappez votre mot de passe" required />
                    <input type="hidden" id="email" name="email" value="<?php echo nl2br(htmlspecialchars($_GET['email']))?>" />
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
        <div class="col-md-3"> </div>
    </div>
</div>


<?php
$content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
