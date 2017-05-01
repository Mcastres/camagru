<?php

/*********************************************
* Require
*/
require 'Class/class.bdd.php';
require 'functions/functions.php';

/*********************************************
* Class
*/
$Database = Database::get_Instance();

    /* Si on recoit bien les informations ainsi que le Captcha */
    if (isset($_POST['submit']))
    {
        /* Creation des variables des champs saisit par l'utilisateur */
		$email = htmlspecialchars(trim($_POST['email']));
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

        /* Si tout les champs sont remplis */
        if (!empty($email) AND !empty($username) AND !empty($password) AND !empty($confirm_password))
        {
            /* On echape tout les mauvais caracteres, si cela fonctionne */
            if (preg_match('/^[a-zA-Z-éè]+$/', $username))
            {
                /* Si les deux mots de passe sont identiques */
                if ($password == $confirm_password)
                {
                    /* Si le mot de passe fait au moins plus de 6 caracteres */
                    if (strlen($password) > 6)
                    {
                        /* Si l'adresse mail est valide (presence du "@") */
                        if (filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            /* Cryptage des mots de passe */
                            $password = hash("whirlpool", $password);
                            $confirm_password = hash("whirlpool", $confirm_password);

                            /* On verifie si l'adresse mail existe deja dans la BDD */
                            $fields = ['email' => $email];
                            $verif_mail = $Database->request("SELECT COUNT(*) as verif FROM users WHERE email = :email", $fields);

                            /* Si l'adresse n'est pas deja prise */
                            if ($verif_mail->verif == 0)
                            {
                                /* Generation de la cle, variable str ainsi que de la date actuel */
                                $cle = str_random(60);
                                $date = date("Y-m-d");

                                /* Insertion de l'utilisateur dans la BDD */
                                $Database->request("INSERT INTO users(email, username, password, confirm_password, creation_date, confirm_date, token, mode)
                                            VALUES('$email', '$username', '$password', '$confirm_password', '$date', NULL, '$cle', '0')");

                                /* On cherche l'id de cet utilisateur */
                                $id = $Database->request("SELECT ID FROM users WHERE Email = :email", $fields);

								$to    =  $email;
                                             $subject = 'Account activation - Camagru';
                                             $header  = "MIME-Version: 1.0\r\n";
                                             $header .= 'From:"TwelveForStudy"<support@twelveforstudy.com>'."\n";
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
                                                                            Welcome '.$username.'
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp; </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" style="font-family: Questrial, Helvetica, sans-serif;  text-align: center; color: #95a5a6; mso-line-height-rule: exactly;  line-height: 28px;">
                                                                            We welcome you on Camagru !. In order to continue your registration, you must confirm your account by clicking the button below. Thank you for joining us, we wish you the best experience on our website.
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
                                                                                            <a href="http://localhost:8080/camagru/confirm_user.php?id='.$id->ID.'&code='.$cle.'" style="font-family: Questrial, Helvetica, sans-serif; font-size: 18px; color: #FFF; vertical-align: middle; text-align: center; text-decoration: none; line-height: 60px; display: block; height: 60px; ">Validate my account</a>
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
                                             $_SESSION['flash']['success'] = "A confirmation email has been sent to your mailbox";

                            }else $_SESSION['flash']['danger'] = "Cette adresse est deja prise";
                        }else $_SESSION['flash']['danger'] = "Ce n'est pas une adresse valide";
                    }else $_SESSION['flash']['danger'] = "Votre mot de passe doit contenir au moins 6 caracteres";
                }else $_SESSION['flash']['danger'] = "Les mots de passes ne sont pas identiques";
            }else $_SESSION['flash']['danger'] = "Votre pseudo ne doit pas contenir de caracteres speciaux";
    	}else $_SESSION['flash']['danger'] = "Veuillez remplir tout les champs";
    }


    /* Si on recoit bien des informations */
    if (isset($_POST['submut']))
    {
        /* Securisation du contenu (', /, etc...) */
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        /* Si on recoit bien les champs */
        if ($username && $password)
        {
            /* Cryptage du mot de passe */
            $password = hash("whirlpool", $password);

            /* On verifie si l'email existe bien dans la BDD */
            $fields = ['username' => $username];
            $verif_mail = $Database->request("SELECT COUNT(*) as verif FROM users WHERE username = :username", $fields);

            /* Si oui... */
            if ($verif_mail->verif == 1)
            {
                /* On check si le mot de passe est le meme que dans la BDD */
                $verif_mail = $Database->request("SELECT password FROM users WHERE username = :username", $fields);

                /* Si oui... */
                if ($password == $verif_mail->password)
                {
                    /* On stock toutes ses infos dans la variable $auth */
                    $auth = $Database->request("SELECT * FROM users WHERE username = :username", $fields);

                    /* Si son compte est Actif (Actif == 1) */
                    if ($auth->mode == 1)
                    {
                        /* Demarage de la session */
                        session_start();
                        $_SESSION['auth'] = (array)$auth;

                        /* Si l'utilisateur a saisit l'option remember */
                        if ($_POST['remember'])
                        {
                            /* On creer une cle qui lui permettra de le log sans saisir ses identifiants a chaque fois... */
                            $remember_token = str_random(250);
                            $query_remember = $Database->request("UPDATE users SET remember_token = '$remember_token' WHERE username = :username", $fields);

                            /* ...grace au cookie remember qui durera une semaine */
                            setcookie('remember', $auth->id . '==' . $remember_token . sha1($auth->id . 'pandaroux'), time() + 60 * 60 * 24 * 7);
                        }

                        /* Redirection vers la page principale */
                        header('location:index.php');

                    }else $_SESSION['flash']['danger'] = "Votre compte n'est pas active, rendez vous dans votre boite mail pour confirmer votre inscription";
                }else $_SESSION['flash']['danger'] = "Votre mot de passe est incorrect";
            }else $_SESSION['flash']['danger'] = "Ce pseudo n'existe pas";
        }else $_SESSION['flash']['danger'] = "Veuillez remplir tout les champs";
    }
?>
