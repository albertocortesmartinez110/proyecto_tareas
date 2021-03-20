<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tareas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="../js/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function () {  //funcion para inciar scripts despues de haberse cargado la pagina


            //funcion  que trae todas las tareas pendientes y completadas
            $(".ver_todas").click(function (e) {
                e.preventDefault();
                var datos = {traer_tareas: 'todos'}
                $.ajax({
                    data: datos,
                    url: "../controlador/controlador.php",
                    type: "post",
                    beforeSend: function () {
                        console.log("procesando preticion");
                    }
                }).done(function (data) {
                    console.log(data);
                    var datos = JSON.parse(data);
                    $(".contenido").empty(); //dejamos vacion el section contenido para llenarlo con los datos que traremos de la consulta

                    //llenamos el section .contenido con los datos que traemos de la consulta
                    for (var i = 0; i < datos.length; i++) {
                        $(".contenido").append("<div>" + datos[i]['id_tarea'] + "</div><div>" + datos[i]['nombres'] + "</div>" +
                            "<div>" + datos[i]['fecha'] + "</div><div>" + datos[i]['comentario'] + "</div>" +
                            "<div>" + datos[i]['estado'] + "</div>" +
                            "<div><a href='#' class='editar' fecha_editar=" + datos[i]['fecha'] + " usuario_editar=" + datos[i]['id_usuario'] + " id_producto=" + datos[i]['id_tarea'] + "><i class='icon ion-md-settings'></i></a></div>" +
                            "<div><a href='#' class='completar' id_producto=" + datos[i]['id_tarea'] + "><i class='icon ion-md-checkmark'></i></a></div>");
                    }
                });
            });


            //funcion para trare las tareas pendientes
            var datos = {traer_tareas_pendientes: 'pendientes'}
            $.ajax({
                data: datos,
                url: "../controlador/controlador.php",
                type: "post",
                beforeSend: function () {
                    console.log("procesando preticion");
                }
            }).done(function (data) {
                console.log(data);
                var datos = JSON.parse(data);
                if (datos != '') {
                    for (var i = 0; i < datos.length; i++) {
                        $(".contenido").append("<div>" + datos[i]['id_tarea'] + "</div><div>" + datos[i]['nombres'] + "</div>" +
                            "<div>" + datos[i]['fecha'] + "</div><div>" + datos[i]['comentario'] + "</div>" +
                            "<div>" + datos[i]['estado'] + "</div>" +
                            "<div><a href='#' class='editar' fecha_editar=" + datos[i]['fecha'] + " usuario_editar=" + datos[i]['id_usuario'] + " id_producto=" + datos[i]['id_tarea'] + "><i class='icon ion-md-settings'></i></a></div>" +
                            "<div><a href='#' class='completar' id_producto=" + datos[i]['id_tarea'] + "><i class='icon ion-md-checkmark'></i></a></div>");
                    }
                } else {

                    var datos = {traer_frases: 'todas'};
                    $.ajax({
                        data: datos,
                        url: "../controlador/controlador.php",
                        type: 'post',
                        beforeSend: function () {
                            console.log("enviando peticion");
                        }
                    }).done(function (data) {
                        console.log(data);
                        var datos = JSON.parse(data);
                        $(".contenido_frases").append("<div>Vaya parece que no tienes nada pendiente.</div><div class='frase'>&ldquo;" + datos[0]['frase'] + "&ldquo;</div><div class='frase'>" + datos[0]['autor'] + "</div>")
                    });
                }
            });


            //funcion que permite al dar click en el icono de visto dar la tarea por completada
            $('.contenido').on('click', '.completar', function (e) {
                e.preventDefault();
                var id_producto = $(this).attr('id_producto');
                var datos = {completar: id_producto};
                $.ajax({
                    data: datos,
                    url: "../controlador/controlador.php",
                    type: "post",
                    beforeSend: function () {
                        console.log("procesando peticion");
                    }
                }).done(function () {
                    window.location.href = "index.php";
                });
            });


            //funcion que permite al darle click en el icono de opciones editar la tarea
            $('.contenido').on('click', '.editar', function (e) {
                e.preventDefault();
                $("#modal_editar").css('visibility', 'visible');

                //llenar los datos del popup editar con los datos traidos por los atributos css
                var id_producto = $(this).attr('id_producto');
                var usuario_editar = $(this).attr('usuario_editar');
                var fecha_editar = $(this).attr('fecha_editar');
                $("#id_tarea_editar").val(id_producto);
                $("#nombre_usuario_editar").val(usuario_editar);
                $("#fecha_tarea_editar").val(fecha_editar);

                //funcion que al cambiar el valor de la id de la tarea, realice consulta a la base de datos y llene los dados correctos del id que pusimos
                $("#id_tarea_editar").change(function () {
                    var datos = {traer_datos_editar: $("#id_tarea_editar").val()};
                    $.ajax({
                        data: datos,
                        url: "../controlador/controlador.php",
                        type: "post",
                        beforeSend: function () {
                            console.log("procesando peticion");
                        }
                    }).done(function (data) {
                        console.log("trayendo datos de la tarea");
                        console.log(data);
                        var datos = JSON.parse(data);
                        $("#nombre_usuario_editar").val(datos[0]['id_usuario']);
                        $("#fecha_tarea_editar").val(datos[0]['fecha']);
                    });
                });
            });


            //funcion que permite editar las tareas

            $("#editar_tarea").click(function (e) {
                e.preventDefault();
                var datos = {
                    id_editar_tarea: $("#id_tarea_editar").val(),
                    observacion_editar_tarea: $("#observacion_editar_tarea").val()
                };
                $.ajax({
                    data: datos,
                    url: "../controlador/controlador.php",
                    type: "post",
                    beforeSend: function () {
                        console.log("procesando peticion");
                    }
                }).done(function () {
                    window.location.href = "index.php";
                });

            });


            //funcion que permite al darle click en el boton de crear tarea, crear una tarea nueva
            $('.crear_tarea').click(function (e) {
                e.preventDefault();
                $(".modal").css('visibility', 'visible');
                $("#crear_tarea").click(function (e) {
                    e.preventDefault();
                    var observacion = $("#observacion").val();
                    var datos = {observacion: observacion};
                    if (observacion != '') {
                        $.ajax({
                            data: datos,
                            url: "../controlador/controlador.php",
                            type: "post",
                            beforeSend: function () {
                                console.log('enviando peticion');
                            }
                        }).done(function () {
                            console.log('procesando datos');
                            window.location.href = "index.php";
                        });
                    } else {
                        alert("no has puesto ninguna observacion");
                    }
                });
            });


            //funcion que permite el cierre del popup de crear tarea
            $(".btn-cerrar-popup").click(function (e) {
                e.preventDefault();
                $(".modal").css('visibility', 'hidden');
            });


            //funcion que permite el cierre del popup de editar tarea
            $(".btn-cerrar-popup_editar").click(function (e) {
                e.preventDefault();
                $(".modal_editar").css('visibility', 'hidden');
            });



            $("#crear_cookie").click(function (e){
                e.preventDefault();
                var nombre_usuario_cookie = $("#nombre_usuario_cookie").val();
                if (nombre_usuario_cookie == null){
                    alert("nombre de usuario vacio");
                }else{
                    var datos = {nombres_usuario_cookie:nombre_usuario_cookie}
                    $.ajax({
                        data:datos,
                        url:'../controlador/controlador.php',
                        type:'post'
                    }).done(function (data){
                        window.location.href='index.php';
                    });
                }
            });
        });
    </script>
</head>
<body>
<?php
if (isset($_COOKIE['id_usuario_cookie'])){

    ?>
<section class="contenedor">
    <h2>Tareas</h2>
    <section class="añadir_tarea">
        <div>Nueva tarea</div>
        <div><a href="#"><input type="button" class="crear_tarea" value="crear"></a></div>
        <div>Ver todas</div>
        <div><a href="#"><input type="button" class="ver_todas" Value="ver todas"></a></div>
    </section>
    <section class="encabezado">
        <div class="cabecera">Tarea</div>
        <div class="cabecera">Nombre</div>
        <div class="cabecera">Fecha</div>
        <div class="cabecera">Comentario</div>
        <div class="cabecera">Estado</div>
        <div class="cabecera">Editar</div>
        <div class="cabecera">Completada</div>
    </section>
    <section class="contenido">

    </section>
    <section class="contenido_frases">
    </section>
</section>
<section class="modal" id="modal">
    <section class="popup" id="popup">
        <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="icon ion-md-close"></i></a>
        <form method="post" action="#">
            <div><h2>Nueva tarea</h2></div>
            <div><textarea id="observacion" required placeholder="Ingrese observacion"></textarea></div>
            <div><input type="submit" class="boton" id="crear_tarea" value="Crear"></div>
        </form>

    </section>
</section>
<section class="modal_editar" id="modal_editar">
    <section class="popup_editar" id="popup_editar">
        <a href="#" id="btn-cerrar-popup_editar" class="btn-cerrar-popup_editar"><i class="icon ion-md-close"></i></a>
        <form method="post" action="#">
            <div><h2>Editar tarea</h2></div>
            <div><input type="number" id="id_tarea_editar"></div>
            <div><input type="text" id="nombre_usuario_editar"></div>
            <div><input type="text" id="fecha_tarea_editar"></div>
            <div><textarea id="observacion_editar_tarea" placeholder="Ingrese observacion"></textarea></div>
            <div><input type="submit" class="boton" id="editar_tarea" value="Editar"></div>
        </form>

    </section>
</section>
<?php
}else{
?>
</body>

<section class="modal_crear_cookie" id="modal_crear_cookie">
    <section class="popup_editar" id="popup_editar">
        <form method="post" action="#">
            <div><h2>Bienvenido</h2></div>
            <div><h4>Vamos a crear un usuario con una cookie, se guardara en el sistema hasta que borres la cookie.</h4></div>
            <div><p>Nombre</p></div>
            <div><input type="text" id="nombre_usuario_cookie" placeholder="Ingresa tu nombre"></div>
            <div><input type="submit" class="boton" id="crear_cookie" value="Crear"></div>
        </form>
    </section>
</section>
<?php
}
?>
</html>