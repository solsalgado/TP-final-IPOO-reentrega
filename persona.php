<?php 
class Persona{
    private $dni;   
    private $nombre;
    private $apellido;

    private $mensajeOperacion;

    public function __construct(){
        $this->nombre = "";
        $this->apellido = "";
        $this->dni = "";
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
   }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setDni($dni){
        $this->dni = $dni;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
   }

    public function Cargar ($nombre, $apellido, $numDocumento) {
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDni($numDocumento);     
      }

     /**
     * funcion insertar
     * @return boolean
     */
   public function Insertar(){
    $baseDatos = new BaseDatos();
    $resp = false;
    $pNombre = $this->getNombre();
    $pApellido = $this->getApellido();
    $doc = $this->getDni();    

    $consultaInsertar = "INSERT INTO persona(nombre, apellido, numDocumento)
                        VALUES ('$pNombre', '$pApellido', '$doc')";
    if ($baseDatos->Iniciar()) {
        if ($baseDatos->Ejecutar($consultaInsertar)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
    } else {
        $this->setMensajeOperacion($baseDatos->getError());
    
    }
    return $resp;
    }

    /**
     * funcion listar
     * @return array
     */
    public function Listar ($condicion = "") {
        $arrayPersonas = null;
        $baseDatos = new BaseDatos();
        
        $consultaListar = "Select * from persona";

        if ($condicion != "") {
            $consultaListar = $consultaListar . 'where' . $condicion;
        }

        $consultaListar .= " order by numDocumento ";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaListar)) {
                $arrayPersonas = [];
                while ($row2 = $baseDatos->Registro()) {
                    $nombre = $row2 ['nombre'];
                    $apellido = $row2 ['apellido'];
                    $documento = $row2 ['numDocumento'];                    

                    $objPersona = new Persona();
                    $objPersona->Cargar( $nombre, $apellido, $documento);
                    array_push($arrayPasajeros, $objPersona);
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }

        return $arrayPersonas;
    }

        /**
     * funcion buscar
     * @return boolean
     */
    public function Buscar($dni){
		$baseDatos=new BaseDatos();
		$consultaPersona = "Select * from persona where numDocumento=".$dni;
		$resp= false;
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultaPersona)){
				if($row2=$baseDatos->Registro()){					
				    $this->setDni($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($baseDatos->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($baseDatos->getError());
		 	
		 }		
		 return $resp;
	}	

    /**
    * funcion modificar
    * @return boolean
    */   
    public function Modificar() { 
        $resp = false;
        $baseDatos = new BaseDatos();
        $dni = $this->getDni();

        $consultaModificar = "UPDATE persona SET apellido='".$this->getApellido()."',nombre='".$this->getNombre()."' WHERE numDocumento = $dni";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaModificar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
                        
        return $resp;
    }

        /**
     * funcion eliminar
     * @return boolean
     */
	public function eliminar(){
		$baseDatos = new BaseDatos();
		$resp = false;
        $numDni = $this->getDni();
		if($baseDatos->Iniciar()){
				$consultaBorrar = "DELETE FROM persona WHERE numDocumento= $numDni";
				if($baseDatos->Ejecutar($consultaBorrar)){
				    $resp=  true;
				}else{
					$this->setmensajeoperacion($baseDatos->getError());
					
				}
		}else{
				$this->setmensajeoperacion($baseDatos->getError());
			
		}
		return $resp; 
	}

    public function __toString(){
        return "Nombre: ". $this->getNombre(). "\n". 
               "Apellido: ". $this->getApellido(). "\n".  
               "DNI: ". $this->getDni(). "\n";
    }
}
