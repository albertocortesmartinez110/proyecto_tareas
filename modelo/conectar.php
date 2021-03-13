<?php

require('config_conexion.php');

class conectar
{
    public static function conexion()
    {
        try {
            $conexion = new PDO('mysql:host=' . DB_HOST . ';port=3308; db_name=' . DB_NAME, DB_USUARIO, DB_CONTRA);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET CHARACTER SET UTF8");
        } catch (Exception $e) {
            die("Error". $e->getMessage());
            echo "Fallo la conexion, linea del error :".$e->getLine();
        }
        return $conexion;
    }
}

?>