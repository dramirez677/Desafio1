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
        include_once 'Modelo/Usuario.php';
        error_reporting(0);

        include 'Cabecera.php';
        ?>

        <!--Migas de pan-->
        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="EnviarCorreo.php" class="active">Enviar correo</a></li>
        </ol>

        <!--Boton volver-->
        <div class="divvolver">
            <form action="index.php" method="POST">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </button>
            </form>
        </div>


        <div class="page-header">
            <h4>Reenvio Contraseña</h4>
        </div>
        <form action="EnviarCorreo.php" method="POST">
            <div class="divespacio">
                <input type="text" name="correo" placeholder="Correo electronico" class="form-control">
                <input type="submit" name="enviarcorreo" value="Enviar" class="btn btn-primary">
            </div>
        </form>


        <?php
        $enviarcorreo = $_REQUEST['enviarcorreo'];

        if (isset($enviarcorreo)) {


//            $para = 'daw2prueba@gmail.com';
//            $titulo = 'daw2_123456';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

            //dirección del remitente 
            $headers .= "From: Daniel Ramirez <daw2prueba@gmail.com>\r\n";

            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            $headers .= "Reply-To: daw2prueba@gmail.com\r\n";

            //ruta del mensaje desde origen a destino 
            $headers .= "Return-path: daw2prueba@gmail.com\r\n";

            //$destinatario="rubendaw2@gmail.com";
            $asunto = "Reinicio de contraseña";
            $cuerpo = "Tu nueva contraseña es:" . rand(1, 1000);

            //$destinatario = $_REQUEST['usuario'];

            mail("dramirez677@gmail.com", $asunto, $cuerpo, $headers);
            ?>

            <script>setTimeout(function () {
                    alert("Correo enviado correctamente");
                    window.location = "index.php";
                }, 100);</script>

            <?php
        }
        ?>

    </body>
</html>
