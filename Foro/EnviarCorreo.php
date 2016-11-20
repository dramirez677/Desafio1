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
        ini_set("SMTP", "ssl://smtp.gmail.com");
        ini_set("smtp_port","465");
        
//            $para = 'daw2prueba@gmail.com';
//            $titulo = 'daw2_123456';
            $para = 'dramirez677@gmail.com';
            $titulo = 'Cambio de contraseña';
            $mensaje = 'Tu nueva contraseña es:' + rand(1, 1000);
            $cabeceras = 'From: webmaster@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($para, $titulo, $mensaje, $cabeceras);
        ?>
    </body>
</html>
