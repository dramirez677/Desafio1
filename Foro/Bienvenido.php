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
        session_start();
        error_reporting(0);
        
        
        //el usu anonimo solo responde temas
        //el administrador puede borrar categorias
        //el usu registrado puede crear temas y responder, pero no borrar categorias, borrar propio tema
        
        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        $conexion = new Conexion("desafio1", "dani", "dani");

        

        //si el usu es administrador o usu registrado
        if ($usu->getId_rol() == 1 || $usu->getId_rol() == 2) {

            $conexion->rellenar_cursor_categorias("categoria");
            ?>

            <div class="panel panel-primary">
                <div class="panel-body">
                    <h4>BIENVENIDO <?php echo $usu->getNombre() ?>!!!</h4>
                </div>
                <div class="panel-footer">¿Que deseas hacer hoy, consultar un tema, abrir uno nuevo, responder otro tema...?</div>
            </div>

            <form action="Bienvenido.php" method="POST">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2 divcategorias">
                        <div class="page-header">
                            <h4>Categorias actuales</h4>
                        </div>
                        <?php
                        while ($conexion->siguiente()) {
                            ?>
                            <input type="submit" name="categoria[]" id="categoria" value="<?php echo $conexion->obtener_campo("nombre") ?>" onclick="anadir()" class="btn btn-primary botoncategorias"><br>
                            <?php
                        }
                        ?>
                    </div>

                    
                    <div class="col-md-3"></div>
                    <div class="col-md-3 divpreguntas" id="caja">
                        <div class="page-header">
                            <h4>Preguntas de la categoria</h4>
                        </div>
                        
                        <?php
                        
                        $categoria = $_REQUEST['categoria'];
                        if (isset($categoria)) {
                            
                            $conexion->rellenar_cursor_idcategoria("categoria", $categoria[0]);
                            if($conexion->siguiente()){
                                
                                $id = $conexion->obtener_campo("id_categoria");
                                $conexion->rellenar_cursor_preguntas("pregunta", $id);
                                
                                while($conexion->siguiente()){
                                    
                                    ?>
                                        <input type="submit" name="" value="<?php echo $conexion->obtener_campo("titulo")?>" class="btn btn-primary">
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </form>
            <?php
        }
        //si el usu es anonimo
        else if ($usu->getId_rol() === 3) {

        }
        $conexion->cerrar_sesion();
        ?>
    </body>
</html>
