<?php
include_once 'Modelo/Usuario.php';
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$usu = new Usuario(0, 0, "", "", "", "", "");
$usu = $_SESSION['u'];
?>
<div class="panel panel-primary">

    <?php
    if ($usu->getNombre() === 'Anonimo') {
        ?>
        <div class="panel-body">
            <a href="index.php"><img src="Imagenes/logo.png" class="logo"></a>
            <h4>BIENVENIDO <?php echo $usu->getNombre() ?></h4>
            
            <form action="ComprobarUsuario.php" method="POST">
                <div class="divloginanonimo">
                    <input type="text" name="usuario" placeholder="Nombre de usuario" class="form-control">
                    <input type="password" name="password" placeholder="Contraseña" class="form-control">
                    <input type="submit" name="aceptarloginanonimo" value="Aceptar" class="btn btn-default botonaceptarloginanonimo">
                </div>
            </form>
        </div>
        <div class="panel-footer">Si ya tienes una cuenta no dudes en iniciar sesion<br> Si todavia no tienes cuenta puedes registrarte para acceder a todas las funcionalidades</div>
        <?php
    } else {
        ?>

        <div class="panel-body">
            <a href="index.php"><img src="Imagenes/logo.png" class="logo"></a>
            <h4>BIENVENIDO <?php echo $usu->getNombre() ?></h4>
        </div>
        <div class="panel-footer">¿Que deseas hacer hoy, consultar un tema, abrir uno nuevo, responder otro tema...?</div>
        <?php
    }
    ?>
</div>
