<?php

echo 'Message : ' . nl2br(htmlspecialchars($e->getMessage()));

?>
<p>
    <a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">Retour à la page précédente</a>
</p>
