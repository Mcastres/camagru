<?php


/**
* Class permettant l'affichage des messages d'erreur
*/
class Data
{
	/**
	* Methode permettant d'afficher les messages flash
	*/
    public function get_message()
    {
        if (isset($_SESSION['flash'])):
            foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert-<?= $type; ?>">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p><?= $message; ?></p>
                </div>
      <?php endforeach;
         unset($_SESSION['flash']);
        endif;
    }

}


?>
