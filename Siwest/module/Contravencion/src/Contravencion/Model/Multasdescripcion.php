<?php

namespace Contravencion\Model;

class Multasdescripcion
{
    public $idMulta;
    public $articuloNro;
    public $descripcion;
    public $jornales;
    public $monto;
    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->idMulta = (isset($data['idMulta'])) ? $data['idMulta'] : null;
        $this->articuloNro = (isset($data['articuloNro'])) ? $data['articuloNro'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
        $this->jornales = (isset($data['jornales'])) ? $data['jornales'] : null;
        $this->monto = (isset($data['monto'])) ? $data['monto'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
