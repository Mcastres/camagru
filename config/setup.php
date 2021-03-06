<?php

/*********************************************
* Require
*/
include("database.php");

try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $bdd->exec($sql);
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$bdd = null;

include_once('../Class/class.bdd.php');

$Database = Database::get_Instance();

$users = "CREATE TABLE IF NOT EXISTS `users`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(3000) NOT NULL,
			  `username` varchar(3000) NOT NULL,
			  `password` varchar(3000) NOT NULL,
			  `liked` varchar(3000) DEFAULT '\\0',
			  `creation_date` DATE NOT NULL,
			  `confirm_date` DATE,
			  `token` varchar(3000) DEFAULT NULL,
			  `remember_token` varchar(3000) DEFAULT NULL,
			  `mode` integer NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$recup = "CREATE TABLE IF NOT EXISTS `recup`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(3000) NOT NULL,
			  `token` varchar(3000),
			  `confirm` integer DEFAULT 0,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$posts = "CREATE TABLE IF NOT EXISTS `posts`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `username` varchar(3000) NOT NULL,
			  `likes` integer DEFAULT 0,
			  `comments` text,
			  `image_path` varchar(3000),
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

if (!file_exists("../public/pictures"))
	mkdir("../public/pictures", 0777, true);

if (!file_exists("../public/montage"))
	mkdir("../public/montage", 0777, true);

$Database->request($users);
$Database->request($recup);
$Database->request($posts);

echo "Database installed :)";

?>
