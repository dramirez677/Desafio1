<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fichero
 *
 * @author Dani
 */
class Fichero {
    private static $fichero;
    private static $nombrefichero;
    
    function __construct() {
        
        self::$nombrefichero = "bitacora.txt";
        //self::$fichero = fopen(self::$nombrefichero,"W");
    }
    
    
    public static function escribir_fichero($mensaje){
        
        self::$fichero = fopen("bitacora.txt","a");
        fwrite(self::$fichero, $mensaje);
        fclose(self::$fichero);
    }

}
