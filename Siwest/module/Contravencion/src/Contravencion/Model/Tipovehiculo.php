<?php

namespace Contravencion\Model;

class Tipovehiculo
{
    public $idTipoVehiculo;
    public $descripcion;
    
    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->idTipoVehiculo = (isset($data['idTipoVehiculo'])) ? $data['idTipoVehiculo'] : null;
        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
