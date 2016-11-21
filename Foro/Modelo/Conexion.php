<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author Dani
 */
class Conexion {

    private $bd;
    private $usuario;
    private $password;
    private $conexion; //variable igualada a mysqli_connect
    private $result; //cursor donde rellena los datos
    private $fila; //fila del cursor para poder obtener sus datos

    function __construct($bd, $usuario, $password) {
        $this->bd = $bd;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->conectar();
    }

    private function conectar() {

        $this->conexion = mysqli_connect("localhost", $this->usuario, $this->password, $this->bd);
        //echo "Conectado correctamente"."<br><br>";
    }

    public function rellenar_cursor_categorias($tabla) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla;
        return $this->result = mysqli_query($this->conexion, $query);
    }
    
    public function rellenar_cursor_login($tabla, $email) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla . " where email='" . $email . "'";
        return $this->result = mysqli_query($this->conexion, $query);
    }

    public function rellenar_cursor_registro($tabla, $email) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla . " where email='" . $email . "'";
        return $this->result = mysqli_query($this->conexion, $query);
    }

    public function insertar_usuario($tabla,$rol, $nombre, $apellidos, $fecha_nac, $email, $password) {


        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }


        $query = "insert into " . $tabla . "(id_rol,nombre,apellidos,fecha_nac,email,password) values (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        

        mysqli_stmt_bind_param($stmt, "ssssss", $val1, $val2, $val3, $val4, $val5, $val6);

        $val1 = $rol;
        $val2 = $nombre;
        $val3 = $apellidos;
        $val4 = $fecha_nac;
        $val5 = $email;
        $val6 = $password;
        

        return mysqli_stmt_execute($stmt);
    }

//    
//    function borrar_fila($tabla,$email){
//        
//        if(isset($this->result)){
//            
//            mysqli_free_result($this->result);
//        }
//        
//        $query = "delete from ".$tabla." where email='".$email."'";
//        return $this->result = mysqli_query($this->conexion, $query);
//        
//    }
//    
//    function actualizar_fila($tabla,$nombre,$apellidos,$edad,$email,$tlf,$email2){
//        
//        if(isset($this->result)){
//            
//            mysqli_free_result($this->result);
//        }
//        
//        $query = "update ".$tabla." set nombre='".$nombre."',apellidos='".$apellidos."',edad=".$edad.",email='".$email."',tlf=".$tlf." where email='".$email2."'";
//        return $this->result = mysqli_query($this->conexion, $query);
//    }



    public function siguiente() {

        return $this->fila = mysqli_fetch_array($this->result);
    }

    public function obtener_campo($campo) {

        return $this->fila[$campo];
    }

    function cerrar_sesion() {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        mysqli_close($this->conexion);
        unset($this->conexion);
    }

}
