<?php


/*********************************************
* Require
*/
require 'Class/class.data.php';
require 'functions/reconnect_cookie.php';
require 'users.php';

/*********************************************
* Class
*/
$Data = new Data;

/*********************************************
* Function
*/
reconnect_from_cookie();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - Sign in</title>
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
			<h1>Formulaire de connexion a Camagru</h1>
			<h3>Content de vous voir :)</h3>
			<label>Email</label>
			<input type="text" name="username" value="<?php if (isset($_POST['username'])){echo $_POST['username'];} ?>" placeholder="username">
			</br>
			<label>Mot de passe</label>
			<input type="password" name="password" value="" placeholder="Password">
			</br>
			<input type="checkbox" name="remember" value="fdgf">Se souvenir de moi ?
			</br>
			<input type="submit" name="submut" value="Envoyer">
		</form>
	</br>
	<a href="signup.php">S'inscrire</a>
	<a href="forgot.php">J'ai oublie mon mot de passe :0</a>
	</div>
	<div class="footer">
		<p>blablabla.</p>
	</div>
	</body>
</html>
