<?php
$title = 'Se connecter';
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-7">


              <!-- Formulaire de connexion -->
          <form id = 'form_ins' method = "post" action = "index.php?action=SignUp">
            <table>
                <tbody>
                  <tr>
                <td><label>Email</label></td>
                <td><input type="text" name="email" required /> </td>
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
                <td><label></label></td>
                <td><input type="submit" value="Valider" /> </td>
              </tr>
            </tbody>
          </table>

        </form>

        <p>Pas encore inscrit ?</p>
        <p><a class="btn btn-primary" href='?action=signInView'>S'inscrire</a></p>
  </div>
</div>
<hr>

<?php $content = ob_get_clean();

require('template.php');
?>
