<?php
require_once('conectar.php');
require_once('objeto_tarea.php');
require_once('objeto_usuario.php');

class manejo_objetos
{
    public static function get_tareas(objeto_usuario $objeto_usuario)
    {
        $pdo = conectar::conexion();
        $query = "select * from tareas where id_usuario=:id_usuario";
        $pdo = $pdo->prepare($query);
        $pdo->execute(array(':id_usuario' => $objeto_usuario->getIdUsuario()));
        $data = $pdo->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function set_tarea(objeto_tarea $objeto_tarea){
        $pdo=conectar::conexion();
        $query="insert into tareas (id_usuario,fecha,comentario,estado) values (:id_usuario,:fecha,:comentario,:estado)";
        $pdo =$pdo->prepare($query);
        $pdo->execute(array(':id_usuario'=>$objeto_tarea->getIdUsuario(),':fecha'=>$objeto_tarea->getFecha(),'comentario'=>$objeto_tarea->getComentario(),'estado'=>$objeto_tarea->getEstado()));
        return $pdo->lastInsertId();
    }
    public static function alter_tarea(objeto_tarea $objeto_tarea){
        $pdo=conectar::conexion();
        $query="update tareas set estado=:estado where id_tarea=:id_tarea";
        $pdo= $pdo->prepare($query);
        $pdo->execute(array(':estado'=>$objeto_tarea->getEstado()));
    }
    public static function set_usuario(objeto_usuario  $objeto_usuario){
        $pdo = conectar::conexion();
        $query = "insert into usuarios (id_usuario,nombres,apellidos,correo,contraseña) values (:id_usuario,:nombres,:apellidos,:correo,:contraseña)";
        $pdo = $pdo->prepare($query);
        $pdo->execute(array(':id_usuario'=>$objeto_usuario->getIdUsuario(),':nombres'=>$objeto_usuario->getNombres(),':apellidos'=>$objeto_usuario->getApellidos(),':correo'=>$objeto_usuario->getCorreo(),':contraseña'=>$objeto_usuario->getContraseña()));
        return $pdo->lastInsertId();
    }
    public static function alter_usuario(objeto_usuario $objeto_usuario){
        $pdo = conectar::conexion();
        $query="update usarios set nombres=:nombres, apellidos=:apellidos, correo=:correo, contraseña=:contraseña where id_usuario=:id_usuario";
        $pdo =$pdo->prepare($query);
        $pdo->execute(array(':id_usuario'=>$objeto_usuario->getIdUsuario(),':nombres'=>$objeto_usuario->getNombres(),':apellidos'=>$objeto_usuario->getApellidos(),':correo'=>$objeto_usuario->getCorreo(),'contraseña'=>$objeto_usuario->getContraseña()));
    }
}

?>