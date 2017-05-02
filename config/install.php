<?php

/*********************************************
* Require
*/
include_once('../Class/class.bdd.php');

/*********************************************
* Class
*/
$Database = Database::get_Instance();

$init = "CREATE DATABASE IF NOT EXISTS camagru";

$Database->request($init);

$users = "CREATE TABLE IF NOT EXISTS `users`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(255) NOT NULL,
			  `username` varchar(255) NOT NULL,
			  `password` varchar(255) NOT NULL,
			  `creation_date` DATE NOT NULL,
			  `confirm_date` DATE,
			  `token` varchar(255) DEFAULT NULL,
			  `remember_token` varchar(255) DEFAULT NULL,
			  `mode` integer NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$recup = "CREATE TABLE IF NOT EXISTS `recup`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(255) NOT NULL,
			  `token` varchar(255),
			  `confirm` integer DEFAULT 0,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$posts = "CREATE TABLE IF NOT EXISTS `posts`
			(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `username` varchar(255) NOT NULL,
			  `likes` integer DEFAULT 0,
			  `comments` text,
			  `image_path` varchar(255),
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

if (file_exists("../public/pictures"));
	mkdir("../public/pictures", 0777, true);

$Database->request($users);
$Database->request($recup);
$Database->request($posts);


?>
