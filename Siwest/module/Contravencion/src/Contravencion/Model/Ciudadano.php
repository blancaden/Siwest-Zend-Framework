<?php

namespace Contravencion\Model;

class Ciudadano
{
    public $idConductor;
    public $nombre;
    public $apellido;
    public $cedula;
    public $direccion;
    public $telefono;
    public $registroNro;
    public $email;
    
    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->idConductor = (isset($data['idConductor'])) ? $data['idConductor'] : null;
        $this->nombre = (isset($data['nombre'])) ? $data['nombre'] : null;
        $this->apellido = (isset($data['apellido'])) ? $data['apellido'] : null;
        $this->cedula = (isset($data['cedula'])) ? $data['cedula'] : null;
        $this->direccion = (isset($data['direccion'])) ? $data['direccion'] : null;
        $this->telefono = (isset($data['telefono'])) ? $data['telefono'] : null;
        $this->registroNro = (isset($data['registroNro'])) ? $data['registroNro'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
