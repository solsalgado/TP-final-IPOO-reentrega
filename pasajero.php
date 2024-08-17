<?php

class Pasajero extends Persona{
   private $telefono;
   private $objViaje;
   
   public function __construct() {
    parent::__construct();
    $this->telefono = "";
    $this->objViaje = "";
   }

   public function getTelefono(){
        return $this->telefono;
   }

   public function getObjViaje(){
        return $this->objViaje;
   }

   public function setTelefono($telefono){
        $this->telefono = $telefono;
   }

    public function setObjViaje($objViaje){
        $this->objViaje = $objViaje;
   }


   public function Setear($nombre, $apellido, $numDocumento, $telefono, $objViaje){
     parent::Cargar($nombre, $apellido, $numDocumento);
     $this->setTelefono($telefono);
     $this->setObjViaje($objViaje);
   }

   /**
     * funcion insertar
     * @return boolean
     */
   public function Insertar(){
    $baseDatos = new BaseDatos();
    $funInsertar = parent::Insertar();
    $pTelefono = $this->getTelefono();
    $id = $this->getObjViaje();
    $resp= false;

    if ($funInsertar) {
        $consultaInsertarP = "INSERT INTO pasajero (telefono, idviaje) VALUES ('$pTelefono', '$id')";
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaInsertarP)) {
                $resp = true;
                } else {
                $this->setMensajeOperacion($baseDatos->getError());
                }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        } 
    }

    return $resp;

    }

    /**
     * funcion listar
     * @return array
     */
    public function Listar ($condicion = "") {
        $arrayPasajeros = null;
        $baseDatos = new BaseDatos();
        
        $consultaPasajeros = "Select * from pasajero";

        if ($condicion != "") {
            $consultaPasajeros = $consultaPasajeros . 'where' . $condicion;
        }

        $consultaPasajeros .= " order by numDocumento ";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaPasajeros)) {
                $arrayPasajeros = [];
                while ($row2 = $baseDatos->Registro()) {     
                    $nombre = $row2 ['nombre'];
                    $apellido = $row2 ['apellido'];                      
                    $nroDoc = $row2['numDocumento'];                            
                    $telefono = $row2 ['telefono'];
                    $idviaje = $row2 ['idviaje'];

                    $objPasajero = new Pasajero();
                    $objPasajero->Setear($nombre, $apellido, $nroDoc, $telefono, $idviaje);
                    array_push($arrayPasajeros, $objPasajero);
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }

        return $arrayPasajeros;
    }

    /**
     * funcion buscar
     * @return boolean
     */
    public function Buscar ($dni) {
        $baseDatos = new BaseDatos();
        $consultaPasajeros = "Select * from pasajero WHERE numDocumento=".$dni;
        $resp = false;

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaPasajeros)) {
                if ($row2 = $baseDatos->Registro()) {
                    parent::Buscar($dni);
                    $this->setTelefono($row2 ['telefono']);
                    $this->setObjViaje($row2 ['idviaje']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
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
        $funMod = parent::Modificar();
        $dni = $this->getDni();

        if($funMod){
            $consultaModificar = "UPDATE pasajero SET telefono='". $this->getTelefono()."',idviaje='". $this->getObjViaje()."' WHERE numDocumento= $dni";
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($consultaModificar)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }
                           
        return $resp;
    }
    

    /**
     * funcion eliminar
     * @return boolean
     */
    public function eliminar () {
        $resp = false;
        $baseDatos = new BaseDatos();
        $numDni = $this->getDni();
        $funEliminar = parent::eliminar();

        if ($baseDatos->Iniciar()) {
            $consultaBorrar ="DELETE FROM pasajero WHERE numDocumento= $numDni";

            if ($baseDatos->Ejecutar($consultaBorrar)) {

                if($funEliminar){
                    $resp=  true;
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
                    
        return $resp;

    }

    public function __toString()
    {
        return 
        parent::__toString().
        "Telefono: " . $this->getTelefono().
        "\n ID Viaje: " . $this->getObjViaje(). "\n";
    }
}
