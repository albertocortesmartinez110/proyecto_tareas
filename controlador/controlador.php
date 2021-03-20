<?php

require_once ('../modelo/manejo_objetos.php');


//funcion para crear tareas
if(isset($_POST['observacion'])){
    $tarea = new objeto_tarea();
    $tarea->setIdUsuario(htmlentities(addslashes($_COOKIE['id_usuario_cookie']),ENT_QUOTES));
    $tarea->setComentario(htmlentities(addslashes($_POST['observacion']),ENT_QUOTES));
    $tarea->setEstado('Pendiente');
    $tarea->setFecha(Date("Y-m-d H:i:s"));
    $resultado = manejo_objetos::set_tarea($tarea);
}
//funcion para traer las tareas del id del usuario que ingreso
if(isset($_POST['traer_tareas'])){
    $usuario = new objeto_usuario();
    $usuario->setIdUsuario($_COOKIE['id_usuario_cookie']);
    $resultado = manejo_objetos::get_tareas($usuario);
    print (json_encode($resultado));
}

if(isset($_POST['traer_tareas_pendientes'])){
    $usuario = new objeto_usuario();
    $usuario->setIdUsuario($_COOKIE['id_usuario_cookie']);
    $resultado = manejo_objetos::get_tareas_pendientes($usuario);
    print (json_encode($resultado));
}
//funcion para coompletar tarea

if (isset($_POST['completar'])){
    $tarea = new objeto_tarea();
    $tarea->setIdTarea(htmlentities(addslashes($_POST['completar'])));
    $tarea->setEstado('Completada');
    var_dump($tarea);
    manejo_objetos::completar_tarea($tarea);
}
if(isset($_POST['traer_datos_editar'])){
    $tarea = new objeto_tarea();
    $tarea->setIdTarea(htmlentities(addslashes($_POST['editar']),ENT_QUOTES));
    $resultado = manejo_objetos::get_tarea_editar($tarea);
    print (json_encode($resultado));
}
if (isset($_POST['id_editar_tarea'])){
    $tarea = new objeto_tarea();
    $tarea->setIdTarea(htmlentities(addslashes($_POST['id_editar_tarea']),ENT_QUOTES));
    $tarea->setComentario(htmlentities(addslashes($_POST['observacion_editar_tarea']),ENT_QUOTES));
    $tarea->setEstado('Pendiente');
    $tarea->setIdUsuario(htmlentities(addslashes($_COOKIE['id_usuario_cookie']),ENT_QUOTES));
    manejo_objetos::editar_tarea($tarea);
}
if (isset($_POST['traer_frases'])){
    $resultado =manejo_objetos::get_frases();
    print (json_encode($resultado));
}

if (isset($_POST['nombres_usuario_cookie'])){
    $usuario = new objeto_usuario();
    var_dump($_POST['nombres_usuario_cookie']);
    $usuario->setNombres(htmlentities(addslashes($_POST['nombres_usuario_cookie']),ENT_QUOTES));
    $id_cookie=manejo_objetos::set_usuario($usuario);
    setcookie('id_usuario_cookie',$id_cookie,time()+5000000,'/proyecto_tareas/');
}
?>