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

if (!$_SESSION['auth'])
	header('location: signin.php');

$fields = ['username' => $_SESSION['auth']['username']];
$pictures = $Database->request("SELECT image_path FROM posts WHERE username = :username", $fields, true);

// // On charge d'abord les images
// $source = imagecreatefrompng("public/pictures/vivaldi.png"); // Le logo est la source
// $destination = imagecreatefromjpeg("public/models/Stormtrooper.jpg"); // La photo est la destination
//
// // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
// $largeur_source = imagesx($source);
// $hauteur_source = imagesy($source);
// $largeur_destination = imagesx($destination);
// $hauteur_destination = imagesy($destination);
//
// // On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
// $destination_x = $largeur_destination - $largeur_source;
// $destination_y =  $hauteur_destination - $hauteur_source;
//
// // On met le logo (source) dans l'image de destination (la photo)
// imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 60);
//
// $formated = str_random(10);
//
// if (!file_exists("public/montage/".$_SESSION['auth']['id'].""))
// 	mkdir("public/montage/".$_SESSION['auth']['id']."");
// // On affiche l'image de destination qui a été fusionnée avec le logo
// imagejpeg($destination, "public/montage/".$_SESSION['auth']['id']."/".$formated.".jpg");
//
// $path = "public/montage/".$_SESSION['auth']['id']."/".$formated.".jpg";
// $username = $_SESSION['auth']['username'];
//
// $Database->request("INSERT INTO posts(username, likes, comments, image_path) VALUES('$username', '0', ' ', '$path')");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - <?php echo $_SESSION['auth']['username']; ?></title>
		<link rel="stylesheet" href="css/main.css">
		<script type="text/javascript">
			var myImg = document.getElementById("photo").src;
		</script>
	</head>
	<body>
		<div class="header">
			<h1>Camagru</h1>
			<div class="nav">
				<a href="index.php?page=1" class="button button4">Home</a>
				<a href="logout.php" class="button button4">Se deconnecter</a>
			</div>
		</div>
			<div class="col-9">
			  <h1>Prenez vous en photo !</h1>
				<video id="video"></video>
				<button id="startbutton">Prendre une photo</button>
				<canvas id="canvas"></canvas>
				<img src="https://s-media-cache-ak0.pinimg.com/originals/08/b0/01/08b0010d557f4e4b87fe26205dac8911.png" id="photo" alt="photo">
			</div>
			<div class="col-3 menu">
			  <ul>
					<?php foreach ($pictures as $img): ?>
						<?php if (!file_exists($img->image_path)): ?>
							<?php $fields = ['image_path' => $img->image_path]; ?>
							<?php $delete = $Database->request("DELETE FROM posts WHERE image_path = :image_path", $fields); ?>
						<?php endif; ?>
						<li><img src="<?php echo $img->image_path; ?>" alt="" height="200" width="200"></li>
					<?php endforeach; ?>
			  </ul>
			</div>


	<script src="js/webcam.js"></script>
	</body>

</html>
