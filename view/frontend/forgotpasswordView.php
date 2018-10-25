<?php

$title = 'Mot de passe oublié';

ob_start();
?>

<div class="row">

    <div class="col-md-7">

        <!-- Formulaire de connexion -->
        <form id = 'form_ins' method = "post" action = "redefinir-mot-de-passe">

            <table>

                <tbody>

                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="email" name="email" required /> </td>
                    </tr>

                    <tr>
                        <td><label></label></td>
                        <td><div class="g-recaptcha" data-sitekey="6LeF904UAAAAABO6m7Sl-pxLDJMS-2E6v1qzSdUP"></div></td>
                    </tr>

                    <tr>
                        <td><label></label></td>
                        <td><input type="submit" value="Valider" /> </td>
                    </tr>

                </tbody>

            </table>

        </form>

        <p>
            Pas encore inscrit ?
        </p>

        <p>
            <a class="btn btn-primary" href='inscription'>S'inscrire</a>
        </p>
    </div>
</div>

<?php $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
