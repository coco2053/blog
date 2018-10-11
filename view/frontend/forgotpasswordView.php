<?php
$title = 'Mot de passe oublié';

ob_start();
?>

<div class="row">
  <div class="col-md-7">


              <!-- Formulaire de connexion -->
          <form id = 'form_ins' method = "post" action = "index.php?action=forgotPassword">
            <table>
                <tbody>
                  <tr>
                <td><label>Email</label></td>
                <td><input type="email" name="email" required /> </td>
              </tr>

              <tr>
                <td><label></label></td>
                <td><input type="submit" value="Valider" /> </td>
              </tr>
            </tbody>
          </table>

        </form>
        <p>Pas encore inscrit ?</p>
        <p><a class="btn btn-primary" href='?action=signUpView'>S'inscrire</a></p>
  </div>
</div>
<hr>

<?php $content = ob_get_clean();

include 'template.php';
?>
