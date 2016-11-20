<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Dani
 */
class Usuario {
    private $id_pregunta;
    private $id_rol;
    private $nombre;
    private $apellidos;
    private $fecha_nac;
    private $email;
    private $password;
    
    function __construct($id_pregunta, $id_rol, $nombre, $apellidos, $fecha_nac, $email, $password) {
        $this->id_pregunta = $id_pregunta;
        $this->id_rol = $id_rol;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fecha_nac = $fecha_nac;
        $this->email = $email;
        $this->password = $password;
    }   

}
