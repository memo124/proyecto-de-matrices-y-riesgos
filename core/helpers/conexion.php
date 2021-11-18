<?php
class Conexion
{
    private static $connection = null;
    private static $statement = null;
    private static $error = null;
    private static $id = null;

    private function conectar()
    {
        $server = 'localhost';
        $database = 'BaseExpo_#20180695_#20180296_#20180385_#20180521';
        $username = 'postgres';
        $password = 'postgres';

        try
        {
            self::$connection = new PDO('pgsql:host='.$server.';dbname='.$database.';port=5432', $username,$password);
        } catch(PDOException $error) {
            //var_dump($error);
            self::setException($error->getcode(),$error->getMessage());
            exit(self::getException());
        }
    }

    private function desconectar()
    {
        self::$connection = null;
        $error = self::$statement->errorInfo();
        if($error[0] != '00000'){
            self::setException($error[0], $error[2]);
        }
    }

    public static function executeRow($query, $values)
    {
        self::conectar();
        self::$statement = self::$connection->prepare($query);
        $state = self::$statement->execute($values);
        self::$id = self::$connection->lastInsertId();
        self::desconectar();
        return $state;
    }

    public static function getRow($query, $values)
    {
        self::conectar();
        self::$statement = self::$connection->prepare($query);
        self::$statement->execute($values);
        self::desconectar();
        return self::$statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getRows($query, $values)
    {
        self::conectar();
        self::$statement = self::$connection->prepare($query);
        self::$statement->execute($values);
        self::desconectar();
        return self::$statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastRowId()
    {
        return self::$id;
    }

    private static function setException($code, $message)
    {
        switch ($code) {
            case '7':
                self::$error = 'Existe un problema con el servidor';
                break;
            case '42703':
                self::$error = 'Nombre de campo desconocido';
                break;
            case '23505':
                self::$error = 'Dato duplicado, no se puede guardar';
                break;
            case '42P01':
                self::$error = 'Nombre de tabla desconocido';
                break;
            case '23503':
                self::$error = 'Registro ocupado, no se puede eliminar';
                break;
            default:
                self::$error = $message;
        }
    }

    public static function getException()
    {
        return self::$error;
    }
}
?>