<?php

class Responsable extends Persona{
    private $numEmpleado; // clave // auto increment
    private $numLicencia;
    private $mensajeOperacion;

    public function __construct() {
        $this->numEmpleado = "";
        $this->numLicencia = "";
        parent::__construct();
       }

    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    public function getNumLicencia(){
        return $this->numLicencia;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
    }

    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }


    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

       public function Cargar ($numEmpleado, $numLicencia, $nombre, $apellido) {
         $this->setNumEmpleado($numEmpleado);
         $this->setNumLicencia($numLicencia);
         $this->setNombre($nombre);
         $this->setApellido($apellido);
       }
    
        /**
        * funcion insertar
        * @return boolean
        */   
       public function Insertar (){
        $baseDatos = new BaseDatos();
        $resp = false;
        $nroLicencia = $this->getNumLicencia();
        $nombreR = $this->getNombre();
        $apellidoR = $this->getApellido();
    
        $consultaInsertar = "INSERT INTO responsable(numLicencia, nombre, apellido)
                            VALUES ('$nroLicencia', '$nombreR', '$apellidoR')";
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
            $arrayResponsables = null;
            $baseDatos = new BaseDatos();
            $consultaResponsables = "Select * from responsable";
    
            if ($condicion != "") {
                $consultaResponsables = $consultaResponsables . 'where' . $condicion;
            }
    
            $consultaResponsables .= " order by numEmpleado ";
    
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($consultaResponsables)) {
                    $arrayResponsables = [];
                    while ($row2 = $baseDatos->Registro()) {
                        $numEmpleado = $row2 ['numEmpleado'];
                        $numLicencia = $row2 ['numLicencia'];
                        $nombre = $row2 ['nombre'];
                        $apellido = $row2 ['apellido'];
    
                        $objResponsable = new Responsable();
                        $objResponsable->Cargar($numEmpleado, $numLicencia, $nombre, $apellido);
                        array_push($arrayResponsables, $objResponsable);
                    }
                } else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
    
            return $arrayResponsables;
        }
    
        /**
        * funcion buscar
        * @return boolean
        */   
        public function Buscar ($nroEmpleado) {
            $baseDatos = new BaseDatos();
            $consultaResponsables = "Select * from responsable where numEmpleado=".$nroEmpleado;
            $resp = false;
    
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($consultaResponsables)) {
                    if ($row2 = $baseDatos->Registro()) {

                        $this->Cargar($nroEmpleado, $row2 ['numLicencia'], $row2 ['nombre'], $row2 ['apellido']);
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
            $consultaModificar = "UPDATE responsable SET numLicencia='".$this->getNumLicencia()."',nombre='".$this->getNombre()."',apellido='".$this->getApellido().
                                "' WHERE numEmpleado=". $this->getNumEmpleado();
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
            $nroE = $this->getNumEmpleado();
            if ($baseDatos->Iniciar()) {
                $consultaBorrar ="DELETE FROM responsable WHERE numEmpleado=$nroE";
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
            return "\n Numero de empleado: " . $this->getNumEmpleado().
            "\n Numero de licencia: " . $this->getNumLicencia().
            "\n Nombre: " . $this->getNombre().
            "\n Apellido: " . $this->getApellido();
        }
    
    
}
