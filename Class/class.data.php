<?php


/**
* Class permettant l'affichage de la Navbar
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
                <!-- <div class="uk-alert-<?= $type; ?>" id="message" uk-alert> -->
                    <!-- <a class="uk-alert-close" style="color: black;" uk-close></a> -->
                    <p><?= $message; ?></p>
                <!-- </div> -->
      <?php endforeach;
         unset($_SESSION['flash']);
        endif;
    }

}


?>
