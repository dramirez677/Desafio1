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
        
        //compruebo si la sesion esta cerrada o no
        if(!isset($_SESSION['sesioncerrada'])){

            $usu = new Usuario(0, 0, "", "", "", "", "");
            $usu = $_SESSION['u'];

            include 'Cabecera.php';

            ?>

            <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="Bienvenido.php">Bienvenido</a></li>
                <li><a href="MostrarRespuestas.php">Respuestas</a></li>
            </ol>

            <div class="row">

                <?php
                if($usu->getNombre() === 'Anonimo'){

                    ?>
                    <div class="col-sm-11">
                        <form action="MostrarCategoriasAnonimo.php" method="POST">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-arrow-left"></span>
                            </button>
                        </form>
                    </div><div class="col-sm-1 divloginanonimo">
                        <div class="divusuario">
                            <form action="index.php" metohd="POST">
                                <input type="submit" name="loguear" value="Login" class="btn btn-primary btn-xs">
                            </form>

                            <form action="Registro.php" metohd="POST">
                                <input type="submit" name="regitro" value="Registrarse" class="btn btn-primary btn-xs botonloginanonimo">
                            </form>
                        </div>
                    </div>

                    <?php
                }
                else{
                    ?>
                    <div class="col-sm-11">
                        <form action="Bienvenido.php" method="POST">
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
                                    <!--pagina donde te salgan los datos del usuario y se puedan modificar-->
                                    <li><input type="submit" name="micuenta" value="Mi Cuenta" class="botonusuario"></li><br>
                                    <li><input type="button" name="email" value="<?php echo $usu->getEmail()?>" class="botonusuario"></li>
                                    <li class="divider"></li>
                                    <!--cierra la sesion del usuario-->
                                    <form action="index.php" method="POST">
                                        <li><input type="submit" name="cerrarsesion" value="Cerrar Sesion" class="botonusuario"></li>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        
            <?php
            $conexion = new Conexion("desafio1", "dani", "dani");
            
            $enviarrespuesta = $_REQUEST['enviarrespuesta'];
            $borrarrespuesta = $_REQUEST['borrarrespuesta'];
            
            if(isset($enviarrespuesta)){
                
                $fecha = getdate();
                $fechaactual = $fecha[year] . "-" . $fecha[mon] . "-" . $fecha[mday];
                
                $conexion->insertar_respuesta("respuesta", $_SESSION['idpregunta'], $usu->getId_registrado(), $_REQUEST['respuesta'], $fechaactual, $usu->getEmail());
            }
            else if(isset ($borrarrespuesta)){
                
                $conexion->borrar_respuesta("respuesta", $_REQUEST['idrespuesta']);
                
                ?>
                    <script>alert("Respuesta borrada correctamente");</script>
                <?php
            }
            
            

            $pregunta = $_REQUEST['pregunta'];
            $idpregunta = $_REQUEST['id'];
            
            if(isset($idpregunta)){
                $_SESSION['idpregunta'] = $idpregunta;
            }
            else{
                $idpregunta = $_SESSION['idpregunta'];
            }

            if (isset($idpregunta)) {

                $conexion->rellenar_cursor_respuestas("pregunta", "respuesta", $idpregunta);
                $conexion->siguiente();
                ?>

                <div class="page-header">
                    <h4><?php echo $conexion->obtener_campo("descripcion")?></h4>
                </div>

                <?php
                $conexion->rellenar_cursor_respuestas("pregunta", "respuesta", $idpregunta);
                while ($conexion->siguiente()) {
                    ?>

                    <div class="form-group">
                        <label for="comment"><?php echo $conexion->obtener_campo("autor") . " - " . $conexion->obtener_campo("fecha") ?></label>
                        <textarea class="form-control" rows="5" style="resize: none;" readonly><?php echo $conexion->obtener_campo("respuesta") ?></textarea>
                        <?php
                        
                        if($usu->getId_rol() == 1){
                            
                            ?>
                            <form action="MostrarRespuestas.php" method="POST">
                                <button type="submit" name="borrarrespuesta" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>
                                <input type="text" name="idrespuesta" value="<?php echo $conexion->obtener_campo("id_respuesta")?>" hidden>
                            </form>
                            <?php
                        }
                        
                        ?>
                    </div>
                    <?php
                }
                ?>

                <hr>
                <form action="MostrarRespuestas.php" method="POST">
                    <div class="divrespuesta">
                        <textarea class="form-control" name="respuesta" rows="5" style="resize: none;" placeholder="Escribe aqui tu respuesta..." required></textarea><br>
                        <input type="submit" name="enviarrespuesta" value="Enviar" class="btn btn-primary botonesrespuesta">
                        <input type="reset" name="borrar" value="Borrar" class="btn btn-primary botonesrespuesta">
                    </div>
                </form>
                <?php
            }
            $conexion->cerrar_sesion();
        }
        //si la sesion esta cerrada redirijo al index.php
        else{
            
            header("Location: index.php");
        }
        ?>
    </body>
</html>
