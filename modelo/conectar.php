<?php
require('datosconexion.php');
class conectar{

    public static function conexion()
    {
        try {
            $conexion = new PDO('mysql:host=' . DB_HOST . ';port=3308; dbname=' . DB_NAME, DB_USUARIO, DB_CONTRA);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET CHARACTER SET UTF8");
        }catch (Exception $e){

            die("Error " .$e->getMessage().' en la fila :'.$e->getLine());
        }
        return $conexion;
    }
}
?>