<?php

$title = 'Ecrire un article';
$description = 'Rediger un nouvel article';

ob_start();

?>

<div class="row">

    <div class="col-md-7">

        <form action="ecrire-article" method="post" enctype="multipart/form-data">

            <p>

                Titre :<input type="text" name="title" maxlength="50" required /> </br>

                Chapo :<input type="text" name="chapo" maxlength="100" required /> </br>

                Contenu : <textarea name="content" rows="4" cols="40" required > </textarea></br>

                Image : <label for="my_file">Fichier (format jpeg | max. 1 Mo) :</label>

                <input type="file" name="my_file" id="my_file"/><br />

                <input type="submit" value="Envoyer" name="addPost" id="i_submit" /></br>

            </p>

        </form>

    </div>

</div>

<script type="text/javascript" script src="public/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">

$('#my_file').change( function() {


    //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob) {

        var fileExtension = ['jpeg', 'jpg'];

        //get the file size and file type from file input field
        var fsize = $('#my_file')[0].files[0].size;


        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {

            alert("Mauvais format ! Seul le JPEG est accepté !");
            $("input[type=submit]").attr('disabled','disabled');
        }


        if(fsize>1048576) {

            alert(fsize +" octets\nFichier trop volumineux !");
            $("input[type=submit]").attr('disabled','disabled');
        }

        if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) > -1  && fsize<1048576 ) {

            $("input[type=submit]").removeAttr('disabled');
        }
    }
});

</script>

<?php $content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
