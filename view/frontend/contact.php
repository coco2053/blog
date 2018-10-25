<?php

$title = 'Contact';

ob_start();
?>

<div class="row">

    <div class="col-md-7">

        <!-- Formulaire de connexion -->
        <form id = 'form_ins' method = "post" action = "contacter">
            <fieldset>
                <label>Nom :</label></br>
                <input type="text" name="lastname" required /></br>
                <label>Prénom :</label></br>
                <input type="text" name="firstname" required /></br>
                <label>Email :</label></br>
                <input type="email" name="email" required /></br>
            </fieldset>
            <fieldset>
                <label>Laisser votre message :</label></br>
                <textarea name="message" id="message" rows="4" cols="40" required ></textarea></br>
                <label><div class="g-recaptcha"
                                        data-sitekey="6LeF904UAAAAABO6m7Sl-pxLDJMS-2E6v1qzSdUP"></div></label></br>
                <label></label>
                <input type="submit" value="Valider" /></br>
            </fieldset>
          </form>
    </div>
</div>

<?php $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
