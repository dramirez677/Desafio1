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

        <link rel="stylesheet" href="estilos.css">

        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script> 
    </head>
    <body>
        <?php
        require 'Modelo/Conexion.php';
        require 'Modelo/Usuario.php';
        require 'Modelo/Fichero.php';
        session_start();
        error_reporting(0);

        $fichero = new Fichero();



        $errorlogin = $_SESSION['errorlogin'];
        $cerrarsesion = $_REQUEST['cerrarsesion'];

        if (isset($errorlogin)) {
            ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Usuario o Contraseña incorrectos
            </div>
            <?php
            unset($_SESSION["errorlogin"]);
        } else if (isset($cerrarsesion)) {

            //recojo el usuario de la sesion
            $usu = new Usuario(0, 0, "", "", "", "", "");
            $usu = $_SESSION['u'];

            //cojo la fecha de hoy y escribo en el fichero que se cierra la sesion con el correo del usuario
            $fecha = getdate();
            $fechaactual = $fecha[year] . "-" . $fecha[mon] . "-" . $fecha[mday];
            Fichero::escribir_fichero($fechaactual . "-" . " Cierra sesion el usuario " . $usu->getEmail() . "\r\n");

            //variable de sesion para controlar si la sesion esta abierta o cerrada
            $_SESSION['sesioncerrada'] = true;
        }



        //el usuario nada mas empezar es anonimo
        $uanonimo = new Usuario(0, 3, "Anonimo", "", "", "", "");
        $_SESSION['u'] = $uanonimo;

        $conexion = new Conexion("desafio1", "dani", "dani");
        $conexion->rellenar_cursor_categorias("categoria");
        ?>
        <div class="panel panel-primary">
            <a href="index.php"><img src="Imagenes/logo.png" class="logo"></a>
            <div class="panel-body">
                <h4>BIENVENIDOS AL FORO!!!</h4>
            </div>
            <div class="panel-footer">Tienes alguna duda? Logueate y abre un tema con tu pregunta</div>
        </div>

        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
        </ol>

        <form action="ComprobarUsuario.php" method="POST">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-2 divcategorias">
                    <div class="page-header">
                        <h4>¿Quieres investigar sobre un tema?<br><br> Aqui tienes las categorias</h4>
                    </div>
                    <?php
                    while ($conexion->siguiente()) {
                        ?>
                        <input type="submit" name="categoria[]" value="<?php echo $conexion->obtener_campo("nombre") ?>" class="btn btn-primary botoncategorias"><br>
                        <?php
                    }
                    $conexion->cerrar_sesion();
                    ?>
                </div>

                <div class="col-md-3"></div>
                <div class="col-md-3 divlogin">
                    <div class="page-header">
                        <h4>¿Ya tienes cuenta en nuestro foro?<br><br> Logueate</h4>
                    </div>
                    <div class="form-group divenlace">
                        <input type="text" name="usuario" placeholder="Usuario" class="form-control">
                        <input type="password" name="password" placeholder="Contraseña" class="form-control">
                        <a href="EnviarCorreo.php">Has olvidado la contraseña</a>
                    </div>

                    <input type="submit" name="aceptar" value="Aceptar" class="btn btn-primary">
                    <input type="reset" name="reiniciar" value="Reiniciar" class="btn btn-primary">
                </div>
            </div>
        </form>

        <div class="row divgeneral">
            <div class="col-md-7"></div>
            <div class="col-md-3">
                <form action="Registro.php" method="POST">
                    <input type="submit" name="registrar" value="Registrar" class="btn btn-primary botonregistro">
                </form>
            </div>
        </div>
    </body>
</html>
