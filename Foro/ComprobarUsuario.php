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
        require 'Modelo/Conexion.php';
        require 'Modelo/Usuario.php';
        session_start();
        error_reporting(0);
        
        
        $usuario = $_REQUEST['usuario'];
        $password = $_REQUEST['password'];
        $index = $_REQUEST['aceptar'];
        $registro = $_REQUEST['registrarme'];
        
        $conexion = new Conexion("desafio1", "dani", "dani");


        if (isset($index)) {

            $conexion->rellenar_cursor_login("registrado", $usuario);

            if ($conexion->siguiente()) {

                $passworddescodificada = base64_decode($conexion->obtener_campo("password"));

                if ($password === $passworddescodificada) {

                    $u = new Usuario($conexion->obtener_campo("id_pregunta"), $conexion->obtener_campo("id_rol"), $conexion->obtener_campo("nombre"), $conexion->obtener_campo("apellidos"), $conexion->obtener_campo("fecha_nac"), $conexion->obtener_campo("email"), $conexion->obtener_campo("password"));
                    $_SESSION['u'] = $u;
                    header("Location: Bienvenido.php");
                }
                else {

                    $_SESSION['errorlogin'] = true;
                    header("Location: index.php");
                }
            }
            $conexion->cerrar_sesion();
        } 
        else if (isset($registro)) {
            
            $email = $_REQUEST['email'];


            $conexion->rellenar_cursor_registro("registrado", $email);

            if ($conexion->siguiente()) {

                $_SESSION['errorregistro'] = true;
                header("Location: Registro.php");
            }
            else{
                
                $passwordcifrada = base64_encode($password);
                $u = new Usuario(0,2,$_REQUEST['nombre'], $_REQUEST['apellidos'], $_REQUEST['fechanacimiento'], $_REQUEST['email'], $_REQUEST['password']);
                $_SESSION['u'] = $u;
                
                if ($conexion->insertar_usuario("registrado", 2, $u->getNombre(), $u->getApellidos(), $u->getFecha_nac(), $u->getEmail(), $passwordcifrada)) {
                    
                    ?>
                        <script>alert("Registrado con exito");</script>
                    <?php
                    flush();
                    header("Location: Bienvenido.php");
                }
                else{
                    
                    ?>
                        <script>alert("Error en el registro");</script>
                    <?php
                    flush();
                }
            }
            $conexion->cerrar_sesion();
        }
        ?>
    </body>
</html>
