<?php 
class Persona{
    private $nombre;
    private $apellido;
    private $dni;

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

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setDni($dni){
        $this->dni = $dni;
    }

    public function __toString(){
        return "Nombre: ". $this->getNombre(). "\n". 
               "Apellido: ". $this->getApellido(). "\n".  
               "DNI: ". $this->getDni(). "\n";
    }
}