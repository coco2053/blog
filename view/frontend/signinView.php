<?php

$title = 'Se connecter';
$description = 'Page de connexion';

ob_start();

?>

<!-- Formulaire de connexion -->
<form id = 'form_ins' method = "post" action = "connecter">

    <table>

        <tbody>

            <tr>
                <td><label>Email</label></td>
                <td><input type="email" name="email" required /> </td>
            </tr>

            <tr>
                <td><label>Mot de passe</label></td>
                <td><input type="password" name="password" required /> </td>
            </tr>

            <!--
            <tr>
                <td><label for="remeber_me">Connexion automatique</label></td>
                <td><input type="checkbox" id="remember_me" name="connexion_auto" value="souvenir"></td>
            </tr>
            -->

            <tr>
                <td><label><div class="g-recaptcha"
                                data-sitekey="6LeF904UAAAAABO6m7Sl-pxLDJMS-2E6v1qzSdUP"></div></label></td>
                <td></td>
            </tr>

            <tr>
                  <td><label></label></td>
                  <td><input type="submit" value="Valider" /> </td>
            </tr>

        </tbody>

    </table>

</form>

<p> <a href='mot-de-passe-oublie'>Mot de passe oublié</a> </p>
<p> Pas encore inscrit ? </p>
<p> <a class="btn btn-primary" href='inscription'>S'inscrire</a> </p>


<?php
 $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
