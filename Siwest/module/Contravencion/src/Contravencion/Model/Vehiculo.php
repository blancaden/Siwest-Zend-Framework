<?php

namespace Contravencion\Model;

class Vehiculo
{
    public $idVehiculo;
    public $nroChapa;
    public $color;
    public $modelo;
    public $cedulaAutomotor;
    public $propietario;
    public $ci_Propietario;
    public $idTipoVehiculo;
    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->idVehiculo = (isset($data['idVehiculo'])) ? $data['idVehiculo'] : null;
        $this->nroChapa = (isset($data['nroChapa'])) ? $data['nroChapa'] : null;
        $this->color = (isset($data['color'])) ? $data['color'] : null;
        $this->modelo = (isset($data['modelo'])) ? $data['modelo'] : null;
        $this->cedulaAutomotor = (isset($data['cedulaAutomotor'])) ? $data['cedulaAutomotor'] : null;
        $this->propietario = (isset($data['propietario'])) ? $data['propietario'] : null;
        $this->ci_Propietario = (isset($data['ci_Propietario'])) ? $data['ci_Propietario'] : null;
        $this->idTipoVehiculo = (isset($data['idTipoVehiculo'])) ? $data['idTipoVehiculo'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
