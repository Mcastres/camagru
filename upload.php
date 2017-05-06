<?php

session_start();

/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');
require 'functions/functions.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();

if (isset($_POST['data']) && $_POST['elements'])
{
	header('Content-type: image/png');
	$img = $_POST['data'];
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$formated = str_random(10);

	if (!file_exists("public/pictures/".$_SESSION['auth']['id'].""))
		mkdir("public/pictures/".$_SESSION['auth']['id']."");
	$success = file_put_contents('public/pictures/'.$_SESSION['auth']['id'].'/'.$formated.'.jpeg', $data);

	// On charge d'abord les images
	$source = imagecreatefrompng($_POST['elements']); // Le logo est la source
	$destination = imagecreatefromjpeg("public/pictures/".$_SESSION['auth']['id']."/".$formated.".jpeg"); // La photo est la destination

	imagealphablending($source, false);
	imagesavealpha($source, true);

	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);

	// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
	$destination_x = ($largeur_destination - $largeur_source) / 2;
	$destination_y =  ($hauteur_destination - $hauteur_source) / 2;

	// On met le logo (source) dans l'image de destination (la photo)
	imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
	imagecolortransparent ($destination, 100);

	$formated_after = str_random(10);

	if (!file_exists("public/montage/".$_SESSION['auth']['id'].""))
		mkdir("public/montage/".$_SESSION['auth']['id']."");

	// On affiche l'image de destination qui a été fusionnée avec le logo
	imagejpeg($destination, "public/montage/".$_SESSION['auth']['id']."/".$formated_after.".jpg");

	$path = "public/montage/".$_SESSION['auth']['id']."/".$formated_after.".jpg";
	$username = $_SESSION['auth']['username'];

	$Database->request("INSERT INTO posts(username, likes, comments, image_path) VALUES('$username', '0', ' ', '$path')");

	unlink("public/pictures/".$_SESSION['auth']['id']."/".$formated.".jpeg");
	if (!glob("public/pictures/".$_SESSION['auth']['id']."/*jpeg"))
		rmdir("public/pictures/".$_SESSION['auth']['id']."");
}
$taillemax = 2097152;

/* Si on recoit qqch... */
if (isset($_FILES['image']) AND (isset($_POST['submit'])) AND !empty($_FILES['image']['name']))
{
    /* Si la taille du fichier est correct */
    if ($_FILES['image']['size'] <= $taillemax) {

            /* On choisit les extensions autorisées */
            $extensions = array('jpg', 'jpeg');

            /* On vérifie l'extension du fichier avatar */
            if(!in_array(substr(strrchr($_FILES['image']['name'], '.'), 1), $extensions))
            {
                $_SESSION['flash']['danger'] = "Le format de votre image doit etre : .jpg, .jpeg";
                header('location: profile.php');
            }

			$exploded = explode(".", $_FILES['image']['name']);
			$i = 0;
			foreach ($exploded as $value)
			{
				if ($i != 0)
				{
					if (!in_array($value, $extensions))
					{
		                $_SESSION['flash']['danger'] = "Le format de votre image doit etre : .jpg, .jpeg";
		                header('location: profile.php');
						exit();
		            }
				}
				$i++;
			}

            /* On récupère l'extension du fichier */
            $extension_fichier = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            /* deuxième vérification d'extension */
            if (!in_array($extension_fichier, $extensions))
            {
                $_SESSION['flash']['danger'] = "Le format de votre image doit etre : .jpg, .jpeg";
                header('location: profile.php');
            }

			$formated = str_random(10);

			if (!file_exists("public/pictures/".$_SESSION['auth']['id'].""))
				mkdir("public/pictures/".$_SESSION['auth']['id']."");

            /* Ce qui donne "chemin d'acces + id.extension" */
            $dest_fichier = "public/pictures/".$_SESSION['auth']['id']."/".$formated.".".$extension_fichier."";

            /* On dort */
            sleep(2);

            /* On renomme le fichier avec son extension et on l'enregistre */
            $var = move_uploaded_file($_FILES['image']['tmp_name'], $dest_fichier);

            /* Si le fichier existe bien */
            $finfo = new finfo(FILEINFO_MIME);
            if (!$finfo)
            {
                $_SESSION['flash']['danger'] = "Nous avons rencontrer un probleme, veuillez ressayer";
                header('location: profile.php');
            }

            /* Derniere verification avec fileinfo */
            $mime = mime_content_type("public/pictures/".$_SESSION['auth']['id']."/".$formated.".".$extension_fichier."");
            $fileinfo = array('image/jpeg', 'image/jpg');

            if (!in_array($mime, $fileinfo))
            {
                $_SESSION['flash']['danger'] = "Impossible d'importer ce fichier";
                header('location: profile.php');
            }
            else
            {
				// On charge d'abord les images
				$source = imagecreatefrompng($_POST['elements']); // Le logo est la source
				$destination = imagecreatefromjpeg("public/pictures/".$_SESSION['auth']['id']."/".$formated.".jpg"); // La photo est la destination

				imagealphablending($source, false);
				imagesavealpha($source, true);

				// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
				$largeur_source = imagesx($source);
				$hauteur_source = imagesy($source);
				$largeur_destination = imagesx($destination);
				$hauteur_destination = imagesy($destination);

				// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
				$destination_x = ($largeur_destination - $largeur_source) / 2;
				$destination_y =  ($hauteur_destination - $hauteur_source) / 2;

				// On met le logo (source) dans l'image de destination (la photo)
				imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
				imagecolortransparent ($destination, 100);

				$formated_after = str_random(10);

				if (!file_exists("public/montage/".$_SESSION['auth']['id'].""))
					mkdir("public/montage/".$_SESSION['auth']['id']."");

				// On affiche l'image de destination qui a été fusionnée avec le logo
				imagejpeg($destination, "public/montage/".$_SESSION['auth']['id']."/".$formated_after.".jpg");

				$path = "public/montage/".$_SESSION['auth']['id']."/".$formated_after.".jpg";
				$username = $_SESSION['auth']['username'];

				$Database->request("INSERT INTO posts(username, likes, comments, image_path) VALUES('$username', '0', ' ', '$path')");

				unlink("public/pictures/".$_SESSION['auth']['id']."/".$formated.".jpg");
				if (!glob("public/pictures/".$_SESSION['auth']['id']."/*jpeg"))
					rmdir("public/pictures/".$_SESSION['auth']['id']."");
				header('location: profile.php');
            }
    }
    else
    {
        $_SESSION['flash']['danger'] = "Votre image ne doit pas depasser 2Mo";
		header('location: profile.php');
    }
}
else
	header('location: profile.php');

?>
