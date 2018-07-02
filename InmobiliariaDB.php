<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InmobiliariaDB
 *
 * @author Miguel Angel Calderon Martin
 */
class InmobiliariaDB {

        protected $mysqli;
        const LOCALHOST = 'localhost';
        const USER = 'root';
        const PASSWORD = '';
        const DATABASE = 'Inmobiliaria';

        public function __construct() {           
        try{
            //conexión a base de datos
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
            $this->mysqli->query("SET NAMES 'UTF8'");
        }catch (mysqli_sql_exception $e){
            //Si no se puede realizar la conexión
            http_response_code(500);
            exit;
            }     
        } 
        
        public function getPromocionDb($id=0){   
            
            $stmt = $this->mysqli->prepare("SELECT * FROM promociones WHERE cod_promocion=? ; ");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();        
            //$Promocions = $result->fetch_all(MYSQLI_ASSOC); 
            $Promocions = $result->fetch_array(MYSQLI_ASSOC); 
            
            $stmt->close();
            return $Promocions;              
        }
        
        
        public function getPromocionesDb(){  
            
            $result = $this->mysqli->query('SELECT * FROM promociones');          
            $Promocions = $result->fetch_all(MYSQLI_ASSOC);          
            $result->close();
            return $Promocions; 
            
        }
        
       public function insertDb($cod_promocion,$nombre='',$descripcion='',$foto='',$direccion='',$localidad='',$cod_provincia){
            $stmt = $this->mysqli->prepare("INSERT INTO promociones VALUES (?,?,?,?,?,?,?); ");
            $stmt->bind_param('isssssi', $cod_promocion,$nombre,
                    $descripcion,$foto,$direccion,$localidad,$cod_provincia);
            $respuesta = $stmt->execute(); 
            $stmt->close();
        return $respuesta; // TRUE SI EL INSERT OK, FALSE SI EL INSERT KO        
    }
    
        public function deleteDb($id=0) {
            $stmt = $this->mysqli->prepare("DELETE FROM promociones WHERE cod_promocion = ?; ");
            $stmt->bind_param('i', $id);
            $resultado = $stmt->execute(); 
            $stmt->close();
            return $resultado;
       }
       
       
       public function updateDb($id, $nuevoNombre,$nuevaDescripcion,$nuevaDireccion,$nuevaFoto) {
            $stmt = $this->mysqli->prepare("UPDATE promociones SET nombre=?,descripcion=?,Direccion=?,foto=? WHERE cod_promocion = ? ; ");
            $stmt->bind_param('ssssi', $nuevoNombre,$nuevaDescripcion,$nuevaDireccion,$nuevaFoto,$id);
            $resultado = $stmt->execute(); 
            $stmt->close();
            return $resultado;    
       }

       

    
    

        
        

        
        
        
        

        

    
    
    
}
