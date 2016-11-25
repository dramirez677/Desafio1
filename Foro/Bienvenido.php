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


        //el usu anonimo solo responde temas
        //el administrador puede borrar categorias
        //el usu registrado puede crear temas y responder, pero no borrar categorias, borrar propio tema

        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        $conexion = new Conexion("desafio1", "dani", "dani");

        

        //esto se hace antes de pintar todo por si hemos borrado una categoria que no se muestre
        $nombrecategoria = $_REQUEST['nombre']; //campo oculto con el nombre de la categoria
        $borrarcategoria = $_REQUEST['borrarcategoria']; //si he pulsado el boton borrar de una categoria
        
        //si he pulsado el boton borrarcategoria
        if (isset($borrarcategoria)) {

            $ids = array();
            $conexion->rellenar_cursor_preguntas("categoria", "pregunta", $nombrecategoria);
            
            while($conexion->siguiente()){
                
                $idpreguntacursor = $conexion->obtener_campo("id_pregunta");
                array_push($ids, $conexion->obtener_campo("id_pregunta"));
            }
            
            for($i=0;$i<count($ids);$i++){
                
                $conexion->borrar_respuestas("respuesta", $ids[$i]);
            }
            
            for($i=0;$i<count($ids);$i++){
                
                $conexion->borrar_pregunta("pregunta", $ids[$i]);
            }
            
            $conexion->borrar_categoria("categoria", $nombrecategoria);
        }



        include 'Cabecera.php';
        ?>

        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="Bienvenido.php" class="active">Bienvenido</a></li>
        </ol>

        <div class="row">
            <div class="col-sm-11">
                <form action="index.php" method="POST">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                    </button>
                </form>
            </div>

            <div class="col-sm-1">
                <div class="divusuario">
                    <div class="btn-group">

                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu" role="menu">
                            <li><input type="button" name="micuenta" value="Mi Cuenta" class="botonusuario"></li><br>
                            <li><input type="button" name="email" value="<?php echo $usu->getEmail()   ?>" class="botonusuario"></li>
                            <li class="divider"></li>
                            <li><input type="button" name="cerrarsesion" value="Cerrar Sesion" class="botonusuario"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 divcategorias">
                <div class="page-header">
                    <h4>Categorias actuales</h4>
                </div>
                <?php
                $conexion->rellenar_cursor_categorias("categoria");

                //si el usuario es adminitrador
                if ($usu->getId_rol() == 1) {

                    while ($conexion->siguiente()) {
                        ?>
                        <form action="Bienvenido.php" method="POST">
                            <button type="submit" name="borrarcategoria" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            <input type="submit" name="categoria[]" value="<?php echo $conexion->obtener_campo("nombre") ?>" class="btn btn-primary botoncategorias"><br>
                            <input type="text" name="nombre" value="<?php echo $conexion->obtener_campo("nombre") ?>" hidden>
                        </form>
                        <?php
                    }
                }
                //si el usuario es usuario registrado
                else if ($usu->getId_rol() == 2) {

                    while ($conexion->siguiente()) {
                        ?>
                        <form action="Bienvenido.php" method="POST">
                            <input type="submit" name="categoria[]" value="<?php echo $conexion->obtener_campo("nombre") ?>" class="btn btn-primary botoncategorias"><br>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>

            <div class="col-md-3"></div>
            <div class="col-md-3 divpreguntas" id="caja">

                <div class="page-header">
                    <h4>Preguntas de la categoria</h4>
                </div>

                <?php
                $categoria = $_REQUEST['categoria']; //si he pulsado el boton de una categoria
                //si he pulsado una categoria, muestro sus respuestas
                if (isset($categoria)) {

                    $conexion->rellenar_cursor_preguntas("categoria", "pregunta", $categoria[0]);
                    while ($conexion->siguiente()) {

                        $conexion->rellenar_cursor_cuantaspreguntas("respuesta", $conexion->obtener_campo("id_pregunta"));
                        $conexion->siguiente2();
                        ?>

                        <form action="MostrarRespuestas.php" method="POST">
                            <button type="submit" name="pregunta[]" value="<?php echo $conexion->obtener_campo("titulo") ?>" class="btn btn-primary">
                                <?php echo $conexion->obtener_campo("titulo") ?> <span class="badge"><?php echo $conexion->obtener_cuantos("total") ?></span> </button><br>
                            <input type="text" name="id" value="<?php echo $conexion->obtener_campo("id_pregunta") ?>" hidden><br>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
