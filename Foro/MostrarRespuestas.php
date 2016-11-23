<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


        <link rel="stylesheet" href="estilos.css">

        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>

        <?php
        require 'Modelo/Conexion.php';
        require 'Modelo/Usuario.php';
        session_start();

        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        ?>

        <div class="panel panel-primary">
            <div class="panel-body">
                <h4>BIENVENIDO <?php echo $usu->getNombre() ?></h4>
            </div>
            <div class="panel-footer">¿Que deseas hacer hoy, consultar un tema, abrir uno nuevo, responder otro tema...?</div>
        </div>

        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="Bienvenido.php" class="active">Bienvenido</a></li>
        </ol>

        <div class="divloginanonimo" style="margin-right: 10px;">

            <form action="index.php" metohd="POST">
                <input type="submit" name="loguear" value="Login" class="btn btn-primary btn-xs">
            </form>

            <form action="Registro.php" metohd="POST">
                <input type="submit" name="regitro" value="Registrarse" class="btn btn-primary btn-xs botonloginanonimo">
            </form>
        </div>

        <?php
        $conexion = new Conexion("desafio1", "dani", "dani");
        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];

        $pregunta = $_REQUEST['pregunta'];
        $idpregunta = $_REQUEST['id'];

        if (isset($idpregunta)) {

            $conexion->rellenar_cursor_respuestas("pregunta", "respuesta", $idpregunta);
            
            ?>
        
            <div class="page-header">
                <h4><?php echo $conexion->obtener_campo("descripcion") ?></h4>
            </div>
        
            <?php

            while ($conexion->siguiente()) {
                ?>
                
                <div class="form-group">
                    <label for="comment"><?php echo $conexion->obtener_campo("autor") . " - " . $conexion->obtener_campo("fecha") ?></label>
                    <textarea class="form-control" rows="5" style="resize: none;" readonly><?php echo $conexion->obtener_campo("respuesta") ?></textarea>
                </div>
                <?php
            }
            ?>
        
            <hr>
            <div class="divrespuesta">
                <textarea class="form-control" rows="5" style="resize: none;" placeholder="Escribe aqui tu respuesta..."></textarea><br>
                <input type="submit" name="enviar" value="Enviar" class="btn btn-primary botonesrespuesta">
                <input type="submit" name="borrar" value="Borrar" class="btn btn-primary botonesrespuesta">
            </div>
            <?php
        }

        //si el usuario es administrador
        if ($usu->getId_rol() == 1) {
            
        }
        $conexion->cerrar_sesion();
        ?>
    </body>
</html>
