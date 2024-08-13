<?php

class Viaje{
    private $idViaje; // auto increment
    private $destino;
    private $cantMaxpasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $importe;
    private $mensajeOperacion;

    public function __construct() {
        $this->idViaje = "";
        $this->destino = "";
        $this->cantMaxpasajeros = "";
        $this->objEmpresa;
        $this->objResponsable;
        $this->importe = "";
       }

    public function getIdviaje(){
        return $this->idViaje;
    }

    public function getDestino(){
        return $this->destino;
    }

    public function getCantMaxPasajeros(){
        return $this->cantMaxpasajeros;
    }

    public function getObjEmpresa(){
        return $this->objEmpresa;
    }

    public function getObjResponsable(){
        return $this->objResponsable;
    }

    public function getImporte(){
        return $this->importe;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdviaje($idViaje){
        $this->idViaje = $idViaje;
    }

    public function setDestino($destino){
        $this->destino = $destino;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros){
        $this->cantMaxpasajeros = $cantMaxPasajeros;
    }

    public function setObjEmpresa($objEmpresa){
        $this->objEmpresa = $objEmpresa;
    }

    public function setObjResponsable($objResponsable){
        $this->objResponsable = $objResponsable;
    }

    public function setImporte($importe){
        $this->importe = $importe;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }
    
       public function Cargar ($idViaje, $destino, $cantMaxPasajeros, $objEmpresa, $objResponsable, $importe) {
         $this->setIdviaje($idViaje);
         $this->setDestino($destino);
         $this->setCantMaxPasajeros($cantMaxPasajeros);
         $this->setObjEmpresa($objEmpresa);
         $this->setObjResponsable($objResponsable);
         $this->setImporte($importe);
       }
    
       /**
        * funcion insertar
        * @return boolean
        */   
       public function Insertar (){
        $baseDatos = new BaseDatos();
        $resp = false;
        $destino =$this->getDestino();
        $cantMaxPasajeros = $this->getCantMaxPasajeros();
        $objEmpresa = $this->getObjEmpresa();
        $objResp = $this->getObjResponsable();
        $idE = $objEmpresa->getIdEmpresa();
        $nroEmpleado = $objResp->getNumEmpleado();
        $importe = $this->getImporte();
    
        $consultaInsertar = "INSERT INTO viaje (destino, cantMaxPasajeros, idEmpresa, numEmpResponsable, importe)
                            VALUES ('$destino', '$cantMaxPasajeros', '$idE', '$nroEmpleado', '$importe')";
        if ($baseDatos->Iniciar()) {
            if ($id = $baseDatos->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdViaje($id);
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
            $arrayViajes = null;
            $baseDatos = new BaseDatos();
            $consultaViajes = "Select * from viaje";
    
            if ($condicion != "") {
                $consultaViajes = $consultaViajes . 'where' . $condicion;
            }
    
            $consultaViajes .= " order by idviaje ";
    
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($consultaViajes)) {
                    $arrayViajes = [];
                    while ($row2 = $baseDatos->Registro()) {
                        $idViaje = $row2 ['idViaje'];
                        $destino = $row2 ['destino'];
                        $cantmaxpasajeros = $row2 ['cantMaxpasajeros'];
                        $idEmpresa = $row2 ['idempresa'];
                        $numEmpResponsable = $row2 ['numEmpResponsable'];
                        $importe = $row2 ['importe'];
    
                        $objViaje = new Viaje();
                        $objViaje->Cargar($idViaje, $destino, $cantmaxpasajeros, $idEmpresa, $numEmpResponsable, $importe);
                        array_push($arrayViajes, $objViaje);
                    }
                } else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
    
            return $arrayViajes;
        }
    
         /**
     * funcion buscar
     * @return boolean
     */
    public function Buscar ($id) {
        $baseDatos = new BaseDatos();
        $consultaEmpresas = "Select * from viaje where idviaje=".$id;
        $resp = false;

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaEmpresas)) {
                if ($row2 = $baseDatos->Registro()) {

                    $this->Cargar($id, $row2 ['destino'], $row2 ['cantMaxpasajeros'], $row2 ['idempresa'], $row2 ['numEmpResponsable'], $row2 ['importe']);

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
        public function Modificar () { 
            $resp = false;
            $baseDatos = new BaseDatos();
            $objEmp = $this->getObjEmpresa();
            $objResp = $this->getObjResponsable();
            $idMod = $objEmp->getIdEmpresa();
            $nroEmpleadoMod = $objResp->getNumEmpleado();
            $consultaModificar = "UPDATE viaje SET destino='".$this->getDestino()."',cantMaxpasajeros='".$this->getCantMaxPasajeros()."',idEmpresa='".$idMod."',numEmpResponsable='".$nroEmpleadoMod."',importe='".$this->getImporte().
                                "' WHERE idviaje=". $this->getIdviaje();
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
        public function eliminar () {
            $resp = false;
            $baseDatos = new BaseDatos();
            if ($baseDatos->Iniciar()) {
                $consultaBorrar ="DELETE FROM viaje WHERE idViaje=".$this->getIdviaje();
                if ($baseDatos->Ejecutar($consultaBorrar)) {
                    $resp = true;
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
            return "\n ID Viaje: " . $this->getIdviaje().
            "\n Destino: " . $this->getDestino().
            "\n Cantidad máxima de pasajeros: " . $this->getCantMaxPasajeros().
            "\n ID Empresa: " . $this->getObjEmpresa().
            "\n Numero de Empleado: " . $this->getObjResponsable().
            "\n Importe: " . $this->getImporte();

        }

}
