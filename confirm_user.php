<?php

/* En cliquant sur le lien fournit dans le mail, cette page va obtenir l'ID ainsi que le code de l'utilisateur */
if (isset($_GET['id']) && isset($_GET['code']))
{
    $ID = $_GET['id'];
    $Code = $_GET['code'];

    require_once 'Class/class.bdd.php';
    $Database = Database::get_Instance();

    $fields =
    [
        'id' => $ID,
        'cle' => $Code
    ];

    /* On execute une requête SQL demandant le numéro Actif du compte comportant l'ID et le Code transmis par la fonction GET */
    $mode = $Database->request("SELECT mode FROM users WHERE id = :id AND token = :cle", $fields);

	$fields = ['id' => $ID];
    /* On demande le token du compte... */
    $token = $Database->request("SELECT token FROM users WHERE id = :id", $fields);

    /* On recupere toutes ses infos */
    $auth = $Database->request("SELECT * FROM users WHERE id = :id", $fields);

    /* On demarre une session */
    session_start();

        /* Si le compte n'est pas active... */
        if ($mode->mode == 0)
        {
            /* Si les codes sont identiques */
            if ($Code == $token->token)
			{
                /* On rend le compte actif */
                $Database->request("UPDATE users SET mode='1', confirm_date=NOW(), token = NULL  WHERE id = :id", $fields);
                $_SESSION['auth'] = (array)$auth;

                /* Message de succes et redirection */
                $_SESSION['flash']['success'] = "Votre compte a bien ete cree.";
                header('location:signin.php');

            /* Le token a expire */
            }
			else
			{
                $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
                header('location:signup.php');
            }

        /* Compte deja active */
        }
		else
		{
             $_SESSION['flash']['danger'] = "Votre compte est deja active";
             header('location:signin.php');
        }
}else header('location: index.php?page=1');

?>
