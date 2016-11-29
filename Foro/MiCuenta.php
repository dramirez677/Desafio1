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

        $usu = new Usuario(0, 0, "", "", "", "", "");
        $usu = $_SESSION['u'];
        
        
        $actualizardatos = $_REQUEST['actualizar'];
        
        if(isset($actualizardatos)){
            
            $conexion = new Conexion("desafio1", "dani", "dani");
            
            //actualizo el usuario
            $conexion->actualizar_datos_perfil("registrado", $_REQUEST['nombre'], $_REQUEST['apellidos'], $_REQUEST['fecha_nac'], $_REQUEST['email'], base64_encode($_REQUEST['password']), $usu->getId_registrado());
            
            //actualizo las variables del usuario
            $usu->setNombre($_REQUEST['nombre']);
            $usu->setApellidos($_REQUEST['apellidos']);
            $usu->setFecha_nac($_REQUEST['fecha_nac']);
            $usu->setEmail($_REQUEST['email']);
            $usu->setPassword($_REQUEST['password']);
            
            //guardo el usuario en sesion con las variables actualziadas
            $_SESSION['u'] = $usu;
        }
        
        
        include 'Cabecera.php';
        
        
        ?>
        
        <!--Migas de pan-->
        <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="MiCuenta.php" class="active">Mi Cuenta</a></li>
        </ol>

        <!--Boton volver-->
        <div class="divvolver">
            <form action="Bienvenido.php" method="POST">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </button>
            </form>
        </div>
        
        
        <div class="page-header">
            <h4>Perfil</h4>
        </div>
        
        
        <form action="MiCuenta.php" method="POST">
        
            <div class="divmicuenta">
                <input type="text" name="nombre" class="form-control" value="<?php echo $usu->getNombre() ?>">
                <input type="text" name="apellidos" class="form-control" value="<?php echo $usu->getApellidos() ?>">
                <input type="date" name="fecha_nac" class="form-control" value="<?php echo $usu->getFecha_nac() ?>">
                <input type="text" name="email" class="form-control" value="<?php echo $usu->getEmail() ?>">
                <input type="password" name="password" class="form-control" value="<?php echo base64_decode($usu->getPassword()) ?>">

                <?php
                if ($usu->getId_rol() == 0) {
                    ?>
                    <input type="text" name="rol" class="form-control" value="Administrador" readonly>
                    <?php
                } else {
                    ?>
                    <input type="text" name="rol" class="form-control" value="Usuario registrado" readonly>
                    <?php
                }
                ?>
                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary">
            </div>
        </form>
    </body>
</html>
