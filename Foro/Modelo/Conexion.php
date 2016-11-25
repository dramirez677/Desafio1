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
    private $result2; //cursor donde rellena los datos2
    private $fila; //fila del cursor para poder obtener sus datos
    private $fila2; //fila2 del cursor2 para poder obtener sus datos

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

        $query = "select * from " . $tabla . " order by id_categoria";
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
    
    public function rellenar_cursor_preguntas($tabla, $tabla2, $nombrecategoria) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla . ",".$tabla2." where ".$tabla.".id_categoria=".$tabla2.".id_categoria and ".$tabla.".nombre='".$nombrecategoria."'";
        return $this->result = mysqli_query($this->conexion, $query);
    }  
    
    public function preguntas($tabla) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from ".$tabla." where ".$tabla.".id_categoria=1";
        $this->result = mysqli_query($this->conexion, $query);
    }   
    
    
    
    public function rellenar_cursor_cuantaspreguntas($tabla, $idpregunta) {

        if (isset($this->result2)) {

            mysqli_free_result($this->result2);
        }

        $query = "select count(*) as total from " . $tabla . " where id_pregunta=".$idpregunta;
        return $this->result2 = mysqli_query($this->conexion, $query);
    }
    
    
    public function rellenar_cursor_respuestas($tabla, $tabla2, $id_pregunta) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla . ",".$tabla2." where ".$tabla.".id_pregunta=".$tabla2.".id_pregunta and ".$tabla.".id_pregunta=".$id_pregunta;
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
    
    function cuantos_tiene_el_cursor(){
        
        return count($this->result);
    }


    function borrar_pregunta($tabla, $idpregunta){
        
        $query = "delete from ".$tabla." where id_pregunta=".$idpregunta;
        return $this->result = mysqli_query($this->conexion, $query);
        
    }
    
    function borrar_respuestas($tabla, $idpregunta){
        
        $query = "delete from ".$tabla." where id_pregunta=".$idpregunta;
        return $this->result = mysqli_query($this->conexion, $query);
        
    }
    
    function borrar_categoria($tabla, $nombrecategoria){
        
        $query = "delete from ".$tabla." where nombre='".$nombrecategoria."'";
        return $this->result = mysqli_query($this->conexion, $query);
        
    }
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
    
    public function siguiente2() {

        return $this->fila2 = mysqli_fetch_array($this->result2);
    }

    public function obtener_campo($campo) {

        return $this->fila[$campo];
    }
    
    public function obtener_cuantos($campo) {

        return $this->fila2[$campo];
    }

    function cerrar_sesion() {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        mysqli_close($this->conexion);
        unset($this->conexion);
    }

}
