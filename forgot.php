<?php

session_start();

/*********************************************
* Require
*/
require 'Class/class.bdd.php';
require 'Class/class.data.php';
require 'functions/functions.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();
$Data = new Data;

/*********************************************
* Request
*/
if (isset($_GET['section']))
    $section = htmlspecialchars(trim($_GET['section']));
else $section = "";

if (isset($_POST['recup_submit'], $_POST['recup_mail']))
{
    if (!empty($_POST['recup_mail']))
    {
        $recup_mail = htmlspecialchars(trim($_POST['recup_mail']));
        if (filter_var($recup_mail, FILTER_VALIDATE_EMAIL))
        {
            $fields = ['email' => $recup_mail];
            $mail_exist_count = $Database->request("SELECT id, username FROM users WHERE email = :email", $fields);

            if ($mail_exist_count)
            {
                $username = $mail_exist_count->username;

                $_SESSION['recup_mail'] = (array)$recup_mail;
                $recup_code = "";

                for ($i=0; $i < 8; $i++)
                    $recup_code .= mt_rand(0,9);

                $mail_recup_exist = $Database->request("SELECT id FROM recup WHERE email = :email", $fields);

                $fields = [
                    'email' => $recup_mail,
                    'token' => $recup_code
                ];
                if ($mail_recup_exist)
                    $recup_insert = $Database->request("UPDATE recup SET token = :token WHERE email = :email", $fields);
                else
                    $recup_insert = $Database->request('INSERT INTO recup(email, token) VALUES (:email, :token)', $fields);

                 /* Envoie du mail */
                 $subject = 'Forgot your password ? - Camagru';
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
                    <link href="https://fonts.googleapis.com/css?family=Nunito:600"  rel="stylesheet" type="text/css">

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
                                                <a href="http://localhost:8080/index.php">
                                                    <img src="https://s-media-cache-ak0.pinimg.com/originals/08/b0/01/08b0010d557f4e4b87fe26205dac8911.png" width="160" border="0" >
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; font-size: 40px; color: #87b885; mso-line-height-rule: exactly;  line-height: 28px;">
                                                What a bad memory !
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; color: #95a5a6; mso-line-height-rule: exactly;  line-height: 28px;">
                                                You have engaged a reset procedure for your password. To do this enter the code given below. If it does not work, repeat the procedure by entering your email, a new code will be sent.
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
                                                                '.$recup_code.'
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

                mail($recup_mail, $subject, $message, $header);

                header('location:forgot.php?section=code');
                $_SESSION['flash']['success'] = "Un email de reinitialisation vous a ete envoye";

            }else $_SESSION['flash']['danger'] = "Cette adresse n'existe pas";

        }else $_SESSION['flash']['danger'] = "Votre adresse est incorrect";

    }else $_SESSION['flash']['danger'] = "Veuillez saisir votre adresse email";
}

if (isset($_POST['verif_submit'], $_POST['verif_code']))
{
    if (!empty($_POST['verif_code']))
    {
        $verif_code = htmlspecialchars(trim($_POST['verif_code']));

        $fields =
        [
            'email' => $_SESSION['recup_mail'][0],
            'code' => $verif_code
        ];
        $verif_req = $Database->request("SELECT COUNT(*) as total FROM recup WHERE email = :email AND token = :code", $fields);

        if ($verif_req->total == 1)
        {
            $fields =
            [
                'email' => $_SESSION['recup_mail'][0],
                'confirm' => 1
            ];
            $up_req = $Database->request("UPDATE recup SET confirm = :confirm WHERE email = :email", $fields);

            header('location:forgot.php?section=changemdp');

        }else $_SESSION['flash']['danger'] = "Code invalide";
    }else $_SESSION['flash']['danger'] = "Veuillez saisir votre code";
}

if (isset($_POST['change_submit']))
{
    if (isset($_POST['newpassword'], $_POST['confirmpassword']))
    {
        $fields = ['email' => $_SESSION['recup_mail'][0]];
        $verif_confirm = $Database->request("SELECT confirm FROM recup WHERE email = :email", $fields);
		$oldpwd = $Database->request("SELECT password FROM users WHERE email = :email", $fields);
        if ($verif_confirm->confirm == 1)
        {
            $mdp = htmlspecialchars(trim($_POST['newpassword']));
            $mdpc = htmlspecialchars(trim($_POST['confirmpassword']));
            if (!empty($mdp) AND !empty($mdpc))
            {
                if ($mdp == $mdpc)
                {
					if (strlen($mdp) > 6)
					{
	                    $mdp = hash("whirlpool", $mdp);
						if ($oldpwd->password != $mdp)
						{
		                    $fields =
		                    [
		                        'email' => $_SESSION['recup_mail'][0],
		                        'mdp' => $mdp
		                    ];
		                    $ins_mdp = $Database->request("UPDATE users SET password = :mdp WHERE email = :email", $fields);

		                    $fields = ['email' => $_SESSION['recup_mail'][0]];
		                    $del_req = $Database->request("DELETE FROM recup WHERE email = :email", $fields);

		                    header('location:signin.php');
						}else $_SESSION['flash']['info'] = "Votre mot de passe doit etre different de l'ancien";
					}else $_SESSION['flash']['info'] = "Le mot de passe doit contenir au moins 6 caracteres";
				}else $_SESSION['flash']['info'] = "Les mots de passes ne sont pas identiques";

            }else $_SESSION['flash']['info'] = "Veuillez saisir tout les champs";
        }else $_SESSION['flash']['info'] = "Veuillez confirmez votre inscription via le mail d'inscription";
    }else $_SESSION['flash']['info'] = "Veuillez saisir tout les champs";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru - :(</title>
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
		<?php if ($section == "code"): ?>
      <div class="container">
  			<form method="post" action="">
            <span class="uk-label">Un email vous a ete transmis</span>
            <input type="text" name="verif_code" placeholder="Verification code">
            <input type="submit" name="verif_submit" value="Submit">
        </form>
      </div>
		<?php endif; ?>
		<?php if ($section == "changemdp"): ?>
      <div class="container">
    		<form method="post" action="">
            <span class="uk-label">Ne l'oubliez pas cette fois :)</span>
    			<br/>
            <input type="password" name="newpassword" placeholder="New password">
    			<br/>
            <input type="password" name="confirmpassword" placeholder="Confirmation">
    			<br/>
        	<input type="submit" name="change_submit" value="Save">
        </form>
      </div>
		<?php endif; ?>
		<?php if ($section == ""): ?>
    <div class="container">
      <h1>On a mauvaise memoire ?</h1>
  		<form method="post" action="">
  		   	<span>Entrer votre adresse email</span>
  			<br/>
  			<input type="email" name="recup_mail" placeholder="Email">
  			<br/>
  			<input type="submit" name="recup_submit" value="Submit">
  	   </form>
     </div>
   	   <?php endif; ?>
       <div class="footer">
         <p>blablabla.</p>
       </div>
	</body>
</html>
