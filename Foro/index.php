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
        session_start();
        error_reporting(0);



        $errorlogin = $_SESSION['errorlogin'];

        if (isset($errorlogin)) {
            ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Usuario o Contraseña incorrectos
            </div>
            <?php
            unset($_SESSION["errorlogin"]);
        }

        //el usuario nada mas empezar en anonimo
        $uanonimo = new Usuario(0, 3, "Anonimo", "", "", "", "");
        $_SESSION['u'] = $uanonimo;
        
        $conexion = new Conexion("desafio1", "dani", "dani");
        $conexion->rellenar_cursor_categorias("categoria");
        ?>

        <div class="panel panel-primary">
            <div class="panel-body">
                <h4>BIENVENIDOS AL FORO!!!</h4>
            </div>
            <div class="panel-footer">Tienes alguna duda? Logueate y abre un tema con tu pregunta</div>
        </div>

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
                    ?>
                </div>

                <div class="col-md-3"></div>
                <div class="col-md-3 divlogin">
                    <div class="page-header">
                        <h4>¿Ya tienes cuanta en nuestro foro?<br><br> Logueate</h4>
                    </div>
                    <div class="form-group divenlace">
                        <input type="text" name="usuario" placeholder="Usuario" class="form-control">
                        <input type="password" name="password" placeholder="Contraseña" class="form-control">
                        <a href="EnviarCorreo.php">Has olvidado la ontraseña</a>
                    </div>

                    <input type="submit" name="aceptar" value="Aceptar" class="btn btn-primary">
                    <input type="reset" name="reiniciar" value="Reiniciar" class="btn btn-primary">
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-3">
                <form action="Registro.php" method="POST">
                    <input type="submit" name="registrar" value="Registrar" class="btn btn-primary botonregistro">
                </form>
            </div>
        </div>
    </body>
</html>
