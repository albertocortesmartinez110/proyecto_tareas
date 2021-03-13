<?php
require_once ('../modelo/manejo_objetos.php');

if(isset($_POST['crear_tarea'])){
    $tarea = new objeto_tarea();
    $tarea->setIdUsuario(htmlentities(addslashes($_POST['id_usuario']),ENT_QUOTES));
    $tarea->setComentario(htmlentities(addslashes($_POST['comentario']),ENT_QUOTES));
    $tarea->setEstado('abierta');
    $tarea->setFecha(Date("Y-m-d H:i:s"));
    $resultado = manejo_objetos::set_tarea($tarea);
}

if(isset($_GET['traer_tareas'])){

    $usuario = new objeto_usuario();
    $usuario->setIdUsuario($_SESSION['id_user_session']);
    $resultado = manejo_objetos::get_tareas($usuario);
    print_r(json_encode($resultado));
}

?>