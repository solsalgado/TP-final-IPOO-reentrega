<?php 

class Empresa
{
    private $idEmpresa; //auto increment
    private $eNombre;
    private $eDireccion;
    private $mensajeOperacion;

    public function __construct() {
        $this->idEmpresa = "";
        $this->eNombre = "";
        $this->eDireccion = "";
    }

    public function getIdEmpresa () {
        return $this->idEmpresa;
    }

    public function getENombre () {
        return $this->eNombre;
    }

    public function getEDireccion () {
        return $this->eDireccion;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdEmpresa ($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setENombre ($eNombre) {
        $this->eNombre = $eNombre;
    }

    public function setEDireccion ($eDireccion) {
        $this->eDireccion = $eDireccion;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function Cargar ($idEmpresa, $eNombre, $eDireccion) {
        $this->setIdEmpresa($idEmpresa);
        $this->setENombre($eNombre);
        $this->setEDireccion($eDireccion);
    }

    /**
     * funcion insertar
     * @return boolean
     */
    public function Insertar (){
        $baseDatos = new BaseDatos();
        $resp = false;
        $nombre = $this->getENombre();
        $direccion = $this->getEDireccion();

        $consultaInsertar = "INSERT INTO empresa (eNombre, eDireccion)
                            VALUES ('$nombre' , '$direccion')";
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
        $arrayEmpresas = null;
        $baseDatos = new BaseDatos();
        $consultaEmpresas = "Select * from empresa";

        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . 'where' . $condicion;
        }

        $consultaEmpresas .= " order by idempresa ";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaEmpresas)) {
                $arrayEmpresas = [];
                while ($row2 = $baseDatos->Registro()) {
                    $idEmpresa = $row2 ['idEmpresa'];
                    $eNombre = $row2 ['eNombre'];
                    $eDireccion = $row2 ['eDireccion'];
                    $objEmpresa = new Empresa();
                    $objEmpresa->Cargar($idEmpresa, $eNombre, $eDireccion);
                    array_push($arrayEmpresas, $objEmpresa);
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }

        return $arrayEmpresas;
    }

    /**
     * funcion buscar
     * @return boolean
     */
    public function Buscar ($id) {
        $baseDatos = new BaseDatos();
        $consultaEmpresas = "Select * from empresa where idempresa=".$id;
        $resp = false;

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consultaEmpresas)) {
                if ($row2 = $baseDatos->Registro()) {

                    $this->Cargar($id, $row2 ['eNombre'], $row2 ['eDireccion']);
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
        $consultaModificar = "UPDATE empresa SET enombre='".$this->getENombre()."',edireccion='".$this->getEDireccion().
                             "' WHERE idEmpresa=". $this->getIdEmpresa();
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
        $idE = $this->getIdEmpresa();
        if ($baseDatos->Iniciar()) {
            $consultaBorrar ="DELETE FROM empresa WHERE idEmpresa=$idE";
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
        return "\n ID Empresa: " . $this->getIdEmpresa().
        "\n Nombre: " . $this->getENombre().
        "\n Direccion: " . $this->getEDireccion();
    }
    
}
