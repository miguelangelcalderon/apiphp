<?php

require_once("InmobiliariaDB.php");
/**
 * Description of InmobiliariaAPI
 *
 * @author Miguel Angel Calderon Martin
 */
class InmobiliariaAPI {
    //put your code here
    public function getPromociones(){
      if($_GET['action']=='promocion'){         
          $db = new InmobiliariaDB();
         if(isset($_GET['id'])){//muestra 1 solo registro si es que existiera ID                 
            $response = $db->getPromocionDb($_GET['id']);                
            // Comprobar si no existe datos para esa promocion
            if (count($response)==0) 
            {
                $this->response(200,"error","No hay datos de la promocion");
            } else 
            {
                echo json_encode($response);
            }
            
            
         }else{ //muestra todos los registros    
            
             $response = $db->getPromocionesDb();  
            // echo count($response);
             
             echo json_encode($response);
             
         }
     }else{
            $this->response(400);
     }    
  }
  
  
       // Metodo para actualizar una promocion
       function updatePromocion() {
            if( isset($_GET['action']) && isset($_GET['id']) ){
                if($_GET['action']=='promocion'){
                    $obj = json_decode( file_get_contents('php://input') );   
                    $objArr = (array)$obj;
                    if (empty($objArr)){                        
                        $this->response(422,"Error",".Json mal formado");                        
                    }else if(isset($obj->nombre)){
                        $db = new InmobiliariaDb();
                        $db->updateDb($_GET['id'], $obj->nombre,$obj->descripcion,$obj->direccion,$obj->foto);
                        $this->response(200,"success","Promocion actualizada");                             
                    }else{
                        $this->response(422,"error","Falta la propiedad 'nombre' en el JSON");                        
                    }     
                    exit;
               }
        }
          $this->response(400);
     }
     
     // Metodo para insertar una nueva promocion
       function insertPromocion() {
            if( isset($_GET['action'])){
                if($_GET['action']=='promocion'){
                    $obj = json_decode( file_get_contents('php://input') );   
                    $objArr = (array)$obj;
                    if (empty($objArr)){                        
                        $this->response(422,"Error",".Json mal formado");                        
                    }else if(isset($obj->nombre) || isset($obj->descripcion) || isset($obj->codigo) || isset($obj->foto) ){
                        $db = new InmobiliariaDb();
                        $db->insertDb($obj->codigo, $obj->nombre, $obj->descripcion, $obj->foto, $obj->direccion, $obj->localidad,$obj->codigoProvincia);
                        //$this->response(200,"success","Nueva promocion insertada");                             
                        $this->response(200,"","OK");                             
                    }else{
                        //$this->response(422,"error","Falta alguna propiedadla propiedad 'nombre' en el JSON");                        
                        $this->response(422,"","KO");                        
                      
                        
                    }     
                    exit;
               }
        }
          $this->response(400);
     }
     
     
     
     
     
     
     // Metodo para eliminar una promocion
     public function deletePromocion() {
         
         if( isset($_GET['action']) && isset($_GET['id']) ){
                 if($_GET['action']=='promocion'){
                      $db = new InmobiliariaDB();
                      $db->deleteDb($_GET["id"]);
                      $this->response(200,"success","Promocion eliminada");
                 }
         }
     }
     
     
     
  
     function response($code=200, $status="", $message="") {
        http_response_code($code);
        if( !empty($status) && !empty($message) ){
            $response = array("status" => $status ,"message"=>$message);  
            echo json_encode($response,JSON_PRETTY_PRINT); 
        }
     } 
       
    
    public function API() {
        header('Content-Type: application/json');                
        $metodo = $_SERVER['REQUEST_METHOD'];
      
        
       switch ($metodo) {
            
       case 'GET'://consulta
            $this->getPromociones();
         
            break;     
        case 'POST'://inserta
            $this->insertPromocion();
            break;                
        case 'PUT'://actualiza
            $this->updatePromocion();
            break;      
        case 'DELETE'://elimina
            $this->deletePromocion();
            break;
        default://metodo NO soportado
           
            break;
        }
      
    }
    
    
}
