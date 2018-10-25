<?php

$title = 'Réinitialiser votre mot de passe';

ob_start();
?>

<div class="row">

    <div class="col-md-7">

        <!-- Formulaire de connexion -->
        <form id = 'form_ins' method = "post" action = "valider-mot-de-passe">

            <table>

                <tbody>

                    <tr>
                        <td><label>Nouveau mot de passe</label></td>
                        <td><input type="password" name="password" required /> </td>
                    </tr>

                    <tr>
                        <td><label>Entrez à nouveau votre mot de passe</label></td>
                        <td><input type="password" name="passwordbis" required /> </br></td>
                        <input type="hidden" id="email" name="email" value="<?php echo $_GET['email']?>" />
                    </tr>

                    <tr>
                        <td><label></label></td>
                      <td><input type="submit" value="Valider" /> </td>
                    </tr>

                </tbody>

            </table>

        </form>

    </div>

</div>

<?php
$content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
