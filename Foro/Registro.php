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

        <script>

            var imagenes = ["Imagenes/captcha1.PNG", "Imagenes/captcha2.PNG", "Imagenes/captcha3.PNG", "Imagenes/captcha4.PNG"];
            var soluciones = ["zkw4", "bmvhky", "944531", "7d6bf"];
            var aleatorio = parseInt(Math.random() * 4);


            window.onload = cargarimagen;
            function cargarimagen() {


                if (aleatorio === 0)
                    document.getElementById("caja").innerHTML += "<img src='" + imagenes[0] + "'/>";
                if (aleatorio === 1)
                    document.getElementById("caja").innerHTML += "<img src='" + imagenes[1] + "'/>";
                if (aleatorio === 2)
                    document.getElementById("caja").innerHTML += "<img src='" + imagenes[2] + "'/>";
                if (aleatorio === 3)
                    document.getElementById("caja").innerHTML += "<img src='" + imagenes[3] + "'/>";

                var validar = function (e) {


                    if (document.getElementById("password").value !== document.getElementById("repetirpassword").value) {

                        alert("Las contraseñas no coinciden");
                        e.preventDefault();
                    }


                    if (document.getElementById("captcha").value !== " ") {

                        if (document.getElementById("captcha").value !== soluciones[aleatorio]) {

                            alert("captcha incorrecto");
                            e.preventDefault();
                        }
                    } else {

                        alert("Escribe el captcha");
                        e.preventDefault();
                    }
                };

                document.getElementById("registrar").addEventListener("click", validar);
            }


        </script>
    </head>
    <body>
        <?php
        session_start();
        error_reporting(0);

        $errorregistro = $_SESSION['errorregistro'];

        if (isset($errorregistro)) {
            
            ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Correo no disponible
            </div>
            <?php
            unset($_SESSION["errorregistro"]);
        }
        
        
        
        
        ?>
        <div class="divimgregistro"><img src="Imagenes/registro.png" class="imgregistro"></div>

        <div class="divregistro">
            <form action="ComprobarUsuario.php" method="POST">
                <input type="text" name="nombre" required class="form-control inputsregistro" placeholder="Nombre">
                <input type="text" name="apellidos" required class="form-control inputsregistro" placeholder="Apellidos">
                <input type="date" name="fechanacimiento" required class="form-control inputsregistro">
                <input type="text" name="email" required class="form-control inputsregistro" placeholder="Email">
                <input type="password" name="password" id="password" required class="form-control inputsregistro" placeholder="Contraseña">
                <input type="password" name="repetirpassword" id="repetirpassword" required class="form-control inputsregistro" placeholder="Confirmar contraseña"><br>
                <div id="caja"></div>
                <input type="text" name="captcha" id="captcha" required class="form-control inputsregistro" placeholder="Captcha"><br><br>


                <input type="submit" name="registrarme" id="registrar" value="Registrarme" class="btn btn-primary buttonregistro"><br><br>

            </form>

            <form action="index.php" method="POST">
                <div>
                    <input type="submit" name="volver" value="Volver" class="btn btn-primary buttonregistro"><br><br>
                </div>
            </form>
        </div>
    </body>
</html>
