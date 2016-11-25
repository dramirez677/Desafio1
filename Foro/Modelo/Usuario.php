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
    private $id_registrado;
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

    
    function getId_registrado() {
        return $this->id_registrado;
    }

    function setId_registrado($id_registrado) {
        $this->id_registrado = $id_registrado;
    }
    
    function getId_pregunta() {
        return $this->id_pregunta;
    }

    function getId_rol() {
        return $this->id_rol;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getFecha_nac() {
        return $this->fecha_nac;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setId_pregunta($id_pregunta) {
        $this->id_pregunta = $id_pregunta;
    }

    function setId_rol($id_rol) {
        $this->id_rol = $id_rol;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setFecha_nac($fecha_nac) {
        $this->fecha_nac = $fecha_nac;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }



}
