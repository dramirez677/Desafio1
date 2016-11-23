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



        <div class="row">

            <div class="col-sm-11">
                <form action="index.php" method="POST">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                    </button>
                </form>
            </div>

            <div class="col-sm-1 divloginanonimo">
                <div class="divusuario">
                    <form action="index.php" metohd="POST">
                        <input type="submit" name="loguear" value="Login" class="btn btn-primary btn-xs">
                    </form>

                    <form action="Registro.php" metohd="POST">
                        <input type="submit" name="regitro" value="Registrarse" class="btn btn-primary btn-xs botonloginanonimo">
                    </form>
                </div>
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

                    while ($conexion->siguiente()) {

                        $conexion->rellenar_cursor_cuantaspreguntas("respuesta", $conexion->obtener_campo("id_pregunta"));
                        $conexion->siguiente2();
                        ?>
                        <form action="MostrarRespuestas.php" method="POST">
                            <button type="submit" name="pregunta[]" value="<?php echo $conexion->obtener_campo("titulo") ?>" class="btn btn-primary botoncategoriasanonimo">
                                <?php echo $conexion->obtener_campo("titulo") ?> <span class="badge"><?php echo $conexion->obtener_cuantos("total") ?></span> </button><br>
                            <input type="text" name="id" value="<?php echo $conexion->obtener_campo("id_pregunta") ?>"><br>
                        </form>
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
