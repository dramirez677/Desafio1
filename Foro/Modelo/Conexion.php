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
    
    
    //-------------------------------------------------------
    //--------------FUNCIONES RELLENAR EL CURSOR-------------
    //-------------------------------------------------------

    public function rellenar_cursor_categorias($tabla) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select * from " . $tabla . " order by id_categoria";
        return $this->result = mysqli_query($this->conexion, $query);
    }
    
     public function rellenar_cursor_categoria($tabla, $nombrecategoria) {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        $query = "select id_categoria from ".$tabla." where nombre='".$nombrecategoria."'";
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

        $query = "select * from " . $tabla . ",".$tabla2." where ".$tabla.".id_pregunta=".$tabla2.".id_pregunta and ".$tabla.".id_pregunta=".$id_pregunta." order by ".$tabla2.".fecha desc";
        return $this->result = mysqli_query($this->conexion, $query);
    }
    
    //-------------------------------------------------------
    //--------------FUNCIONES INSERTAR-----------------------
    //-------------------------------------------------------

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
    
    public function insertar_categoria($tabla, $nombrecategoria) {


        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }


        $query = "insert into " . $tabla . "(nombre) values (?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        

        mysqli_stmt_bind_param($stmt, "s", $val1);

        $val1 = $nombrecategoria;

        return mysqli_stmt_execute($stmt);
    }
    
    public function insertar_pregunta($tabla, $id_categoria, $id_usuario, $descripcion, $titulo, $fechaactual) {


        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }   


        $query = "insert into " . $tabla . "(id_categoria,id_usuario,descripcion,titulo,fecha) values (?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        

        mysqli_stmt_bind_param($stmt, "iisss", $val1,$val2,$val3,$val4,$val5);

        $val1 = $id_categoria;
        $val2 = $id_usuario;
        $val3 = $descripcion;
        $val4 = $titulo;
        $val5 = $fechaactual;

        return mysqli_stmt_execute($stmt);
    }
    
    public function insertar_respuesta($tabla, $id_pregunta, $id_usuario, $respuesta, $fecha, $autor) {


        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }   


        $query = "insert into " . $tabla . "(id_pregunta,id_registrado,respuesta,fecha,autor) values (?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        

        mysqli_stmt_bind_param($stmt, "iisss", $val1,$val2,$val3,$val4,$val5);

        $val1 = $id_pregunta;
        $val2 = $id_usuario;
        $val3 = $respuesta;
        $val4 = $fecha;
        $val5 = $autor;

        return mysqli_stmt_execute($stmt);
    }
    
    //-------------------------------------------------------
    //--------------FUNCIONES BORRAR REGISTROS---------------
    //-------------------------------------------------------


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
    
    //-------------------------------------------------------
    //----------FUNCIONES RECORRER EL CURSOR Y FETCH---------
    //-------------------------------------------------------

    public function siguiente() {

        return $this->fila = mysqli_fetch_array($this->result);
    }
    
    public function siguiente2() {

        return $this->fila2 = mysqli_fetch_array($this->result2);
    }
    
    public function hay_datos(){
        
        return count($this->result) > 0;
    }
    
    
    //-------------------------------------------------------
    //---------FUNCIONES OBTENER CAMPOS DE LA FILA-----------
    //-------------------------------------------------------

    public function obtener_campo($campo) {

        return $this->fila[$campo];
    }
    
    public function obtener_cuantos($campo) {

        return $this->fila2[$campo];
    }
    
    //-------------------------------------------------------
    //--------------FUNCION PARA CERRAR LA SESION-----------
    //-------------------------------------------------------

    function cerrar_sesion() {

        if (isset($this->result)) {

            mysqli_free_result($this->result);
        }

        mysqli_close($this->conexion);
        unset($this->conexion);
    }

}
