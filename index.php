<?php

session_start();
/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');
require 'functions/formate_comments.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();

if (!isset($_GET['page']))
	header('location: index.php?page=1');

$perPage = 6;
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

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - Home</title>
	</head>
	<body>
		<?php if ($_SESSION['auth']): ?>
			<a href="profile.php">Mon profil</a>
			<a href="logout.php">Se deconnecter</a>
		<?php else: ?>
			<a href="signin.php">Se connecter</a>
			<a href="signup.php">S'inscrire</a>
		<?php endif; ?>
		<?php $reqPosts = $Database->request("SELECT * FROM posts ORDER BY id DESC LIMIT $start, $perPage", $fields, true); ?>
		<?php foreach ($reqPosts as $post): ?>
			<div class="">
				<img src="<?php echo $post->image_path; ?>" alt="" height="100" width="100">
				<p><?php echo "@".$post->username; ?></p>
				<ul>
					<?php formate_comment($post->comments) ?>
				</ul>
				<form action="comments.php?post=<?php echo $post->id; ?>&id=<?php echo $_SESSION['auth']['id']; ?>" method="post">
					<input type="text" name="comment" value="">
					<br/>
					<input type="submit" name="submit" value="Leave comment">
					<input type="submit" name="like" value="Like <?php echo $post->likes; ?>">
				</form>
			</div>
			<br>
		<?php endforeach; ?>

		<!-- Pagination -->
        <div id="pagination">
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

	</body>
</html>
