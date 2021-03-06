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
        error_reporting(0);

        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        ?>

        <?php include 'Cabecera.php' ?>

        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
        </ol>



        <div class="row">

            <div class="col-sm-11">
                <form action="ComprobarUsuario.php" method="POST">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                    </button>
                </form>
            </div>
        </div>



        <div class="page-header">
            <h4>Preguntas actuales</h4>
        </div>

        <div class="mostrarcategoanonimo">
            <?php
            $conexion = new Conexion("desafio1", "dani", "dani");

            $categoria = $_SESSION['catego'];
            if (isset($categoria)) {

                $conexion->rellenar_cursor_preguntas("categoria", "pregunta", $categoria);
                
                    if($conexion->hay_datos()){

                    while ($conexion->siguiente()) {

                        $conexion->rellenar_cursor_cuantaspreguntas("respuesta", $conexion->obtener_campo("id_pregunta"));
                        $conexion->siguiente2();
                        ?>
                        <form action="MostrarRespuestas.php" method="POST" style="text-align: center;">
                            <button type="submit" name="pregunta[]" value="<?php echo $conexion->obtener_campo("titulo") ?>" class="btn btn-primary">
                                <?php echo $conexion->obtener_campo("titulo") ?> <span class="badge"><?php echo $conexion->obtener_cuantos("total") ?></span> </button><br>
                            <input type="text" name="id" value="<?php echo $conexion->obtener_campo("id_pregunta") ?>" hidden><br>
                        </form>
                        <?php
                    }
                }
                else{    
                ?>
                    <div class="divnocategorias">
                        <h4>No existen preguntas en esta categoria</h4>
                    </div> 
                <?php
                }
                ?>
            </div>
            <?php
        }
        $conexion->cerrar_sesion();
        ?>
    </body>
</html>
