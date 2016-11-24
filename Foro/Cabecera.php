<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$usu = new Usuario(0, 0, "", "", "", "", "");
$usu = $_SESSION['u'];
?>


<div class="panel panel-primary">
    <div class="panel-body">
        <h4>BIENVENIDO <?php echo $usu->getNombre() ?></h4>
    </div>

    <?php
    if ($usu->getNombre() === 'Anonimo') {
        ?>
        <div class="panel-footer">Si ya tienes una cuenta no dudes en iniciar sesion<br> Si todavia no tienes cuenta puedes registrarte para acceder a todas las funcionalidades</div>
        <?php
    } else {
        ?>
        <div class="panel-footer">¿Que deseas hacer hoy, consultar un tema, abrir uno nuevo, responder otro tema...?</div>
        <?php
    }
    ?>
</div>
