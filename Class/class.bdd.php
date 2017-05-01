<?php

/**
* Class permettant la gestion de la base de donnee
*/
class Database
{
    /* Instance de la PDO */
    private $PDO_Instance;

    /* Instance de la Database */
    private static $instance = null;

    /* Connexion avec la bdd */
    private function __construct()
    {
        try
        {
            $options =
            [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->PDO_Instance = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', '', $options);
        }
        catch (PDOException $e)
        {
            exit('Erreur : ' . $e->getMessage());
        }
    }


    /**
    * Retourne l'instance de Database
    * @return Instance pour Database
    */
    public static function get_Instance()
    {
        if (is_null(self::$instance))
            self::$instance = new Database();
        return self::$instance;
    }


    /**
    * Fonction permettant d'effectuer une requete prepare
    * @param Requetes sql
    * @param Champs a traiter ?
    * @param Multiple resultats ?
    * @return Objet
    */
    public function request($sql, $fields = false, $multiple = false)
    {
        try
        {
            $statement = $this->PDO_Instance->prepare($sql);

            if ($fields)
            {
                foreach ($fields as $key => $value)
                {
                    if (is_int($value))
                        $data_type = PDO::PARAM_INT;
                    else if (is_bool($value))
                        $data_type = PDO::PARAM_BOOL;
                    else if (is_null($value))
                        $data_type = PDO::PARAM_NULL;
                    else
                        $data_type = PDO::PARAM_STR;

                    $statement->bindValue(':'.$key, $value, $data_type);
                }
            }
            $statement->execute();

            if ($multiple)
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
            else
                $result = $statement->fetch(PDO::FETCH_OBJ);

            $statement->closeCursor();

            return $result;
        }
        catch (Exception $e)
        {
            exit($e->getMessage());
        }
    }

    /**
    * Fonction permettant d'executer une requete direct
    * @param Requetes sql
    * @param Champs a traiter ?
    */
    public function execute($sql, $fields = false)
    {
        try
        {
            $statement = $this->PDO_Instance->execute($sql);

            if ($fields)
            {
                foreach ($fields as $key => $value)
                {
                    if (is_int($value))
                        $data_type = PDO::PARAM_INT;
                    else if (is_bool($value))
                        $data_type = PDO::PARAM_BOOL;
                    else if (is_null($value))
                        $data_type = PDO::PARAM_NULL;
                    else
                        $data_type = PDO::PARAM_STR;

                    $statement->bindValue(':'.$key, $value, $data_type);
                }
            }
        }
        catch (Exception $e)
        {
            exit($e->getMessage());
        }
    }

    /**
    * Fonction permettant d'executer une requete query
    * @param Requetes sql
    * @param Champs a traiter ?
    */
    public function query($sql)
    {
        try
        {
            $statement = $this->PDO_Instance->query($sql);
        }
        catch (Exception $e)
        {
            exit($e->getMessage());
        }
    }
}

?>
