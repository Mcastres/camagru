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
	</head>
	<body>
	<?php $Data->get_message(); ?>

		<form action="" method="post">
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

	</body>
</html>
