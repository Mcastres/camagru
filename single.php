<?php

session_start();

/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');
include_once('Class/class.data.php');
require 'functions/formate_comments.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();
$Data = new Data;

/*********************************************
* Requete
*/
if (!isset($_GET['id']))
	header('location: index.php?page=1');

$id = htmlspecialchars(trim($_GET['id']));

$fields = ['id' => $id];
$post = $Database->request("SELECT * FROM posts WHERE id = :id", $fields);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - post(<?php echo $post->id; ?>)</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<div class="header">
			<h1>Camagru</h1>
			<div class="nav">
				<a href="index.php?page=1" class="button button4">Home</a>
				<?php if (isset($_SESSION['auth'])): ?>
					<a href="profile.php" class="button button4">Mon profil</a>
					<a href="logout.php" class="button button4">Se deconnecter</a>
				<?php else: ?>
					<a href="signin.php" class="button button4">Se connecter</a>
					<a href="signup.php" class="button button4">S'inscrire</a>
				<?php endif; ?>
			</div>
		</div>

		<?php $Data->get_message(); ?>

		<div class="container" style="text-align:center;">
			<img src="<?php echo $post->image_path; ?>" alt="" height="500" width="600">
				<p><?php echo "posted by @".$post->username; ?></p>
				<hr>
				<?php formate_comment($post->comments); ?>
				<form action="comments.php?post=<?php echo $post->id; ?>&id=<?php if (isset($_SESSION['auth'])){echo $_SESSION['auth']['id'];} ?>" method="post">
					<input type="text" name="comment" value="" placeholder="Mon commentaire">
					<input type="submit" name="submit" value="Commenter">
					<br/>
					<input type="submit" name="like" value="J'aimes <?php echo $post->likes; ?>">
				</form>
		</div>

		<div class="footer">
		  <p>@camagru</p>
		</div>
	</body>
</html>
