<?php

/*********************************************
* Include_once
*/
include_once('Class/class.bdd.php');

/*********************************************
* Class
*/
$Database = Database::get_Instance();

if (isset($_POST['submit']) && isset($_POST['comment']) && isset($_GET['id']) && isset($_GET['post']) && !empty($_POST['comment']))
{
	$id = htmlspecialchars(trim($_GET['id']));
	$post = htmlspecialchars(trim($_GET['post']));
	$comment = htmlspecialchars(trim($_POST['comment']));

	$fields = ['id' => $post];
	$find_post = $Database->request("SELECT username FROM posts WHERE id = :id", $fields);

	$fields = ['username' => $find_post->username];
	$find_user = $Database->request("SELECT email FROM users WHERE username = :username", $fields);

	$fields = ['id' => $id];
	$find_id = $Database->request("SELECT username FROM users WHERE id = :id", $fields);

	$array = array('E+[zk#', "@".$find_id->username.":", $comment);
	$formated = implode(" ", $array);

	if ($find_id->username && $find_post->username)
	{
		$fields = ['username' => $find_post->username];
		$add_comment = $Database->request("UPDATE posts SET comments = CONCAT(comments, '$formated') WHERE username = :username", $fields);
		$to  =  $find_user->email;
				 $subject = 'New comment ! - Camagru';
				 $header  = "MIME-Version: 1.0\r\n";
				 $header .= 'From:"Camagru"<support@twelveforstudy.com>'."\n";
				 $header .= 'Content-Type:text/html; charset="UTF-8"'."\n";
				 $header .= 'Content-Transfer-Encoding: 8bit';
				 $message = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns:v="urn:schemas-microsoft-com:vml">

				<head>
					<meta http-equiv="content-type" content="text/html; charset=utf-8">
					<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
					<link href="https://fonts.googleapis.com/css?family=Questrial"  rel="stylesheet" type="text/css">

				</head>
				<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
					<div style="background-color:#34495e;">
					  <!--[if gte mso 9]>
					  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
						<v:fill type="tile" src="" color="#34495e"/>
					  </v:background>
					  <![endif]-->
					  <table width="100%" cellpadding="0" cellspacing="0" border="0">
					  <tbody>
						<tr>
						  <td valign="top" align="left" background="">
							<div>
								 <table align="center" width="590" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>
										<tr>
											<td style="text-align: center;">
												<a href="http://localhost:8080/camagru/index.php">
													<img src="https://s-media-cache-ak0.pinimg.com/originals/08/b0/01/08b0010d557f4e4b87fe26205dac8911.png" width="160" border="0" >
												</a>
											</td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>
										<tr>
											<td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; font-size: 40px; color: #87b885; mso-line-height-rule: exactly;  line-height: 28px;">
												Hey '.$find_post->username.'
											</td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>
										<tr>
											<td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; color: #95a5a6; mso-line-height-rule: exactly;  line-height: 28px;">
												'.$find_id->username.' just commented your post
											</td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>
										<tr>
											<td align="center">
												<table align="center" width="240" >
													<tbody>
														<tr>

															<td align="center" height="60" bgcolor="#87b885" style="font-family: Questrial, Helvetica, sans-serif; font-size: 18px; color: #FFF; vertical-align: middle; text-align: center;">
																<a href="http://localhost:8080/camagru/signin.php" style="font-family: Questrial, Helvetica, sans-serif; font-size: 18px; color: #FFF; vertical-align: middle; text-align: center; text-decoration: none; line-height: 60px; display: block; height: 60px; ">'.$find_id->username.' says: '.$comment.'</a>
															</td>

														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>

										<tr>
											<td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; color: #95a5a6; mso-line-height-rule: exactly;  line-height: 28px;">
												Have a good day
											</td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>
										<tr>
											<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
										</tr>

									</tbody>
								 </table>
							</div>
						  </td>
						</tr>
					   </tbody>
					  </table>
					</div>
				</body>
				</html>

				 ';

				 /* Envoie du mail HTML */
				 mail($to, $subject, $message, $header);
		header('location: index.php?page=1');
	}
	else
		header('location: index.php?page=1');
}
else
	header('location: index.php?page=1');

if (isset($_POST['like']) && isset($_GET['id']) && isset($_GET['post']))
{
	$id = htmlspecialchars(trim($_GET['id']));
	$post = htmlspecialchars(trim($_GET['post']));

	$fields = ['id' => $post];
	$find_post = $Database->request("SELECT username, id FROM posts WHERE id = :id", $fields);

	$fields_id = ['id' => $id];
	$find_id = $Database->request("SELECT username, liked FROM users WHERE id = :id", $fields_id);

	$exploded = explode("/", $find_id->liked);
	$exit = 0;
	foreach ($exploded as $key => $value)
	{
		if ($value == $post)
			$exit = 1;
	}
	if ($find_post->username && $exit == 0)
	{
		$fields = ['username' => $find_post->username];
		$add_like = $Database->request("UPDATE posts SET likes = likes + 1 WHERE username = :username", $fields);
		$liked = "/" . $find_post->id;
		$add_liked = $Database->request("UPDATE users SET liked = CONCAT(liked, '$liked') WHERE id = :id", $fields_id);
		header('location: index.php?page=1');
	}
	else
		header('location: index.php?page=1');
}

?>
