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
    </head>
    <body>
        <?php
        require 'Modelo/Usuario.php';
        session_start();
        error_reporting(0);

        //el usuario anonimo solo responde temas
        //el administrador puede borrar categorias
        //el usuario registrado puede crear temas y responder, pero no borrar categorias, borrar propio tema

        $usuario = $_SESSION['u'];


        //si el usuario es administrador o usuario rewgistrado
        if ($usuario->getId_rol() === 1 || $usuario->getId_rol() === 2) {

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
                        
                        <?php
                        
                        //saber el id de la categoria
                        $conexion->rellenar_cursor_preguntas("pregunta", 1);
                        ?>
                    </div>
                </div>
            </form>

            <?php
        }
        //si el usuario es anonimo
        else if ($usuario->getId_rol() === 3) {

            
        }
        ?>
    </body>
</html>
