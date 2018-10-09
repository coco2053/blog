<?php
$title = 'Inscription';
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-7">


          <!-- Formulaire d'inscription -->
          <form id = 'form_ins' method = "post" action = "?action=signIn">
            <table>
                <tbody>

              <tr>
                <td><label>Adresse email</label></td>
                <td><input type="email" name="email"  required/> </td>

              </tr>

              <tr>
                <td><label>Pseudo</label></td>
                <td><input type="text" name="username" required /> </td>
              </tr>

              <tr>
                <td><label>Nom</label></td>
                <td><input type="text" name="lastname" required /> </td>
              </tr>

              <tr>
                <td><label>Prénom</label></td>
                <td><input type="text" name="firstname" required /> </td>
              </tr>

              <tr>
                <td><label>Mot de passe</label></td>
                <td><input type="password" name="password" required /> </td>
              </tr>

              <tr>
                <td><label>Entrez à nouveau votre mot de passe</label></td>
                <td><input type="password" name="passwordbis" required /> </br></td>
              </tr>

              <tr>
                <td><label></label></td>
                <td><input type="submit" value="Valider" /> </td>
              </tr>
            </tbody>
          </table>

        </form>

        <p>Déja inscrit ?</p>
        <p><a class="btn btn-primary" href='?action=signUpView'>Se connecter</a></p>
  </div>
</div>
<hr>

<?php $content = ob_get_clean();

include 'template.php';
?>
