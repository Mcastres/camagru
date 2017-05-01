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
	</head>
	<body>
	<?php $Data->get_message(); ?>

		<form action="" method="post">
			<label>Email</label>
			<input type="text" name="username" value="<?php if (isset($_POST['username'])){echo $_POST['username'];} ?>" placeholder="username">
			</br>
			<label>Mot de passe</label>
			<input type="password" name="password" value="" placeholder="Password">
			</br>
			<input type="checkbox" name="remember" value="fdgf">Remember me ?
			</br>
			<input type="submit" name="submut" value="Envoyer">
		</form>
		<a href="forgot.php">J'ai oublie mon mot de passe :0</a>
	</body>
</html>
