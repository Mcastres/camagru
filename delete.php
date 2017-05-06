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

if (isset($_POST['submit']) && isset($_GET['id']) && $_GET['id'] > 0)
{
	$id = htmlspecialchars(trim($_GET['id']));
	$fields = ['id' => $id];
	$find_image = $Database->request("SELECT image_path FROM posts WHERE id = :id", $fields);
	unlink($find_image->image_path);
	if (empty(glob("public/montage/".$_SESSION['auth']['id']."/*.jpg")))
	{
		$path = "public/montage/" . $_SESSION['auth']['id'];
		rmdir($path);
	}
	$delete = $Database->request("DELETE FROM posts WHERE id = :id", $fields);
	header('location: profile.php');
}
else
	header('location: profile.php');

?>
