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
            <div class="panel-footer">Si ya tienes una cuenta no dudes en iniciar sesion<br> Si todavia no tienes cuenta puedes registrarte para acceder a todas las funcionalidades</div>
        </div>

        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
        </ol>

        <div class="page-header">
            <h4>Categorias actuales</h4>
        </div>

        <div class="mostrarcategoanonimo">
            <form action="MostrarRespuestas.php" method="POST">
                <?php
                $conexion = new Conexion("desafio1", "dani", "dani");

                $categoria = $_SESSION['catego'];
                if (isset($categoria)) {

                    $conexion->rellenar_cursor_idcategoria("categoria", $categoria);
                    if ($conexion->siguiente()) {

                        $id = $conexion->obtener_campo("id_categoria");
                        $conexion->rellenar_cursor_preguntas("pregunta", $id);

                        while ($conexion->siguiente()) {
                            ?>
                            <input type="submit" name="pregunta[]" value="<?php echo $conexion->obtener_campo("titulo") ?>" class="btn btn-primary botoncategoriasanonimo"><br>
                            <?php
                        }
                        ?>
                    </form>
                </div>
                <?php
            }
        }
        $conexion->cerrar_sesion();
        ?>
    </body>
</html>
