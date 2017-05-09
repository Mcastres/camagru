<?php

session_start();
/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');
require 'Class/class.data.php';
require 'functions/functions.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();
$Data = new Data;

if (!$_SESSION['auth'])
	header('location: signin.php');

$fields = ['username' => $_SESSION['auth']['username']];
$pictures = $Database->request("SELECT image_path, id FROM posts WHERE username = :username ORDER BY id DESC", $fields, true);

$elements = glob("public/models/*.png");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - <?php echo $_SESSION['auth']['username']; ?></title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<div class="header">
			<h1>Camagru</h1>
			<div class="nav">
				<a href="index.php?page=1" class="button button4">Home</a>
				<a href="logout.php" class="button button4">Se deconnecter</a>
			</div>
		</div>

		<?php $Data->get_message(); ?>

		<div class="row">
			<div class="col-9">
			  <h1>Prenez vous en photo !</h1>
				<form action="upload.php" method="post" enctype="multipart/form-data">
			  	<h3>Choisissez votre element !</h3>
				<?php $i = 0; ?>
				<?php foreach($elements as $elem): ?>
					<img src="<?php echo $elem; ?>" alt="" height="150" width="150">
					<input type="radio" name="elements" id="<?php echo $i; ?>" value="<?php echo $elem; ?>" onclick="affiche_bouton(<?php echo $i; ?>)">
					<?php $i++; ?>
				<?php endforeach; ?>
				<br>
				<br>
				<br>
				<video id="video"></video>
				<button id="startbutton" disabled="true">Prendre une photo</button>
				<canvas id="canvas"></canvas>
				<img src="public/models/Suiton.png" id="photo" alt="photo">
				<br/>
					<br/>
					<input type="file" name="image" value="">
					<br/>
					<br/>
					<input type="submit" name="submit" value="Uploader">
				</form>
			</div>
			<div class="col-3 menu">
			  <ul>
				<?php foreach ($pictures as $img): ?>
					<?php if (!file_exists($img->image_path)): ?>
						<?php $fields = ['image_path' => $img->image_path]; ?>
						<?php $delete = $Database->request("DELETE FROM posts WHERE image_path = :image_path", $fields); ?>
					<?php endif; ?>
					<li>
						<img src="<?php echo $img->image_path; ?>" alt="" height="250" width="300">
						<form action="delete.php?<?php echo "id=".$img->id; ?>" method="post">
							<input type="submit" name="submit" value="Supprimer post">
						</form>
					</li>
				<?php endforeach; ?>
			  </ul>
			</div>
		</div>

		<div class="footer">
		  <p>@camagru</p>
		</div>

	<script type="text/javascript">
	function affiche_bouton(i)
	{
		document.getElementById("startbutton").disabled = false;
		document.getElementById(i).setAttribute("checked", "");
		var radio = document.querySelector('input[name=elements]:checked').value;
		document.getElementById('photo').setAttribute("src", radio);
	}
	</script>
	<script src="js/webcam.js"></script>
	</body>
</html>
