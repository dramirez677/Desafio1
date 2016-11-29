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
        require 'Modelo/Fichero.php';
        session_start();
        error_reporting(0);
        
        
        $usuario = $_REQUEST['usuario'];
        $password = $_REQUEST['password'];
        $index = $_REQUEST['aceptar'];
        $registro = $_REQUEST['registrarme'];
        $categoria = $_REQUEST['categoria'];
        
        
        
        //si el usuario es anonimo muestro solo las categorias en la pagina MostrarCategoriasAnonimo
        if(isset($categoria)){
            
            $_SESSION['catego'] = $categoria[0];
            header("Location: MostrarCategoriasAnonimo.php");
        }
        
        
        
        $conexion = new Conexion("desafio1", "dani", "dani");

        //si vengo de la pagina de inicio
        if (isset($index)) {

            $conexion->rellenar_cursor_login("registrado", $usuario);

            if ($conexion->siguiente()) {

                $passworddescodificada = base64_decode($conexion->obtener_campo("password"));

                if ($password === $passworddescodificada) {

                    //si exite la variable cerrar sesion en la sesion la eliminamos para que el usuario nuevo que se loguea pueda acceder
                    if(isset($_SESSION['sesioncerrada'])) unset ($_SESSION['sesioncerrada']);
                    
                    $fecha = getdate();
                    $fechaactual = $fecha[year]."-".$fecha[mon]."-".$fecha[mday];
                    Fichero::escribir_fichero($fechaactual."-"." Nueva conexion del usuario ".$usuario."\r\n");
                    
                    $u = new Usuario($conexion->obtener_campo("id_pregunta"), $conexion->obtener_campo("id_rol"), $conexion->obtener_campo("nombre"), $conexion->obtener_campo("apellidos"), $conexion->obtener_campo("fecha_nac"), $conexion->obtener_campo("email"), $conexion->obtener_campo("password"));
                    $u->setId_registrado($conexion->obtener_campo("id_registrado"));
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
        //si vengo de la pagina de registro
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
                
                if ($conexion->insertar_usuario("registrado", 2, $u->getNombre(), $u->getApellidos(), $u->getFecha_nac(), $u->getEmail(), $passwordcifrada)) {
                    
                    $conexion->rellenar_cursor_registro("registrado", $email);
                    if($conexion->siguiente()){
                        
                        $u->setId_registrado($conexion->obtener_campo("id_registrado"));
                        $_SESSION['u'] = $u;
                    }
                    
                    ?>
                        <script>alert("Registrado con exito");</script>
                    <?php
                    header("Location: Bienvenido.php");
                }
                else{
                    
                    ?>
                        <script>alert("Error en el registro");</script>
                    <?php
                }
            }
            $conexion->cerrar_sesion();
        }
        ?>
    </body>
</html>
