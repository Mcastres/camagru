<?php

session_start();

/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');
require 'functions/formate_comments.php';
require 'functions/comments_number.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();

/*********************************************
* Requete
*/
if (!isset($_GET['page']))
	header('location: index.php?page=1');

$perPage = 7;
$postsNumber = $Database->request("SELECT COUNT(*) as total FROM posts");
$pagesNumber = ceil($postsNumber->total / $perPage);

/* Gestion des pages passe en $_GET */
if (!empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesNumber)
{
    $_GET['page'] = intval($_GET['page']);
    $currentPage = $_GET['page'];
}
else
    $currentPage = 1;
$start = ($currentPage - 1) * $perPage;

$fields = ['' => ''];
$reqPosts = $Database->request("SELECT * FROM posts ORDER BY id DESC LIMIT $start, $perPage", $fields, true);


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - Home</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<div class="header">
			<h1>Camagru</h1>
			<div class="nav">
				<?php if (isset($_SESSION['auth'])): ?>
					<a href="profile.php" class="button button4">Mon profil</a>
					<a href="logout.php" class="button button4">Se deconnecter</a>
				<?php else: ?>
					<a href="signin.php" class="button button4">Se connecter</a>
					<a href="signup.php" class="button button4">S'inscrire</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<?php foreach ($reqPosts as $post): ?>
					<div class="col-3 posts">
						<img src="<?php echo $post->image_path; ?>" alt="" height="290" width="290">
						<p><?php echo "posted by @".$post->username; ?></p>
						<form action="comments.php?post=<?php echo $post->id; ?>&id=<?php if (isset($_SESSION['auth'])){echo $_SESSION['auth']['id'];} ?>" method="post">
							<input type="submit" class="button button4" name="like" value="J'aimes <?php echo $post->likes; ?>">
						</form>

						<a href="single.php?id=<?php echo $post->id; ?>" class="button button4">Commentaires <?php comments_number($post->comments); ?></a>
					</div>
				<?php endforeach; ?>
			</div>

	        <div>
				<?php for($i = 1; $i <= $pagesNumber ; $i++): ?>
	            <?php if($i == $currentPage)
            		echo $i.' ';
             	  elseif ($i == $currentPage + 1)
                	echo '<a href="index.php?page='.$i.'" class="next">'.$i.'</a> ';
             	  else
                	echo '<a href="index.php?page='.$i.'">'.$i.'</a> ';
	     		?>
				<?php endfor; ?>
	        </div>
		</div>

		<div class="footer">
		  <p>@camagru</p>
		</div>
	</body>
</html>
