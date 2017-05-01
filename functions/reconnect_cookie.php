<?php

function reconnect_from_cookie()
{
    if(isset($_COOKIE['remember']))
    {
        require_once 'Class/class.bdd.php';
		$Database = Database::get_Instance();

        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];

		$fields = ['id' => $user_id];
        $user = $Database->request('SELECT * FROM users WHERE id = :id', $fields);
        if ($user)
        {
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'pandaroux');
            if ($expected == $remember_token)
            {
                session_start();
                $_SESSION['auth'] = (array)$user;
                header('location:index.php');
            }
        }
    }
}

?>
