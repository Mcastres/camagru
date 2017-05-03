<?php

session_start();
/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');

/*********************************************
* Class
*/
$Database = Database::get_Instance();

if (!$_SESSION['auth'])
	header('location: signin.php');

	var_dump($_POST);
if (isset($_POST['data']))
	echo "string";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - <?php echo $_SESSION['auth']['username']; ?></title>
		<script type="text/javascript">
			var myImg = document.getElementById("photo").src;
		</script>
	</head>
	<body>
		<a href="index.php?page=1">Home</a>
		<a href="upload.php">Upload</a>
		<a href="logout.php">Se deconnecter</a>

		<video id="video"></video>
		<button id="startbutton">Prendre une photo</button>
		<canvas id="canvas"></canvas>
		<img src="https://s-media-cache-ak0.pinimg.com/originals/08/b0/01/08b0010d557f4e4b87fe26205dac8911.png" id="photo" alt="photo">
	<script src="js/webcam.js"></script>
	<?php var_dump($_POST); ?>
	</body>

</html>
