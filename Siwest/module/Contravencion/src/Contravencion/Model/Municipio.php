<?php

namespace Contravencion\Model;

class Municipio
{
    public $idMunicipio;
    public $municipio;
    
    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->idMunicipio = (isset($data['idMunicipio'])) ? $data['idMunicipio'] : null;
        $this->municipio = (isset($data['municipio'])) ? $data['municipio'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
