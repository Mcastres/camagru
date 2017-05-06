<?php


/*********************************************
* Require
*/
require 'Class/class.data.php';
require 'users.php';

/*********************************************
* Class
*/
$Data = new Data;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - Sign up</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<div class="header">
			<h1>Camagru</h1>
			<div class="nav">
				<a href="index.php?page=1" class="button button4">Home</a>
			</div>
		</div>
		<?php $Data->get_message(); ?>

	<div class="container">
		<form action="" method="post">
			<h1>Formulaire d'inscription a Camagru</h1>
			<h3>Bienvenue a vous :)</h3>
			<label>Email</label>
			<input type="email" name="email" value="<?php if (isset($_POST['email'])){echo $_POST['email'];} ?>" placeholder="email">
			</br>
			<label>Username</label>
			<input type="text" name="username" value="<?php if (isset($_POST['username'])){echo $_POST['username'];} ?>" placeholder="username">
			</br>
			<label>Mot de passe</label>
			<input type="password" name="password" value="" placeholder="Password">
			</br>
			<label>Confirmer le mot de passe</label>
			<input type="password" name="confirm_password" value="" placeholder="Confirm Password">
			</br>
			<input type="submit" name="submit" value="Envoyer">
		</form>
		<br/>
		<a href="signin.php">Se connecter</a>
	</div>
	<div class="footer">
		<p>blablabla.</p>
	</div>
	</body>
</html>
