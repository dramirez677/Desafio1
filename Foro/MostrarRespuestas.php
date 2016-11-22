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

        $conexion = new Conexion("desafio1", "dani", "dani");
        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        $titulo = $_REQUEST['pregunta'];

        if (isset($titulo)) {

            $conexion->rellenar_cursor_idpregunta("pregunta", $titulo[0]);
            if ($conexion->siguiente()) {

                $idpregunta = $conexion->obtener_campo("id_pregunta");
                $descripcion = $conexion->obtener_campo("descripcion");
                $conexion->rellenar_cursor_respuestas("respuesta", $idpregunta);
                ?>
                <div class="page-header">
                    <h4><?php echo $descripcion ?></h4>
                </div>
                <?php
                while ($conexion->siguiente()) {
                    ?>
                    <div class="form-group">
                        <label for="comment"><?php echo $conexion->obtener_campo("autor") ?></label>
                        <textarea class="form-control" rows="5" id="comment"><?php echo $conexion->obtener_campo("respuesta") ?></textarea>
                    </div>
                    <?php
                }
            }
        }

        //si el usuario es administrador
        if ($usu->getId_rol() == 1) {
            
        }
        ?>
    </body>
</html>
