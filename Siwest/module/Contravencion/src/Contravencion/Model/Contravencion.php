<?php

namespace Contravencion\Model;

class Contravencion {

    public $idContravencion;
    public $idConductor;
    public $idMunicipio;
    public $idTipoVehiculo;
    public $idMulta;
    public $km;
    public $numeroChapa;
    public $idUsuario;
    public $ruta;
    public $excedenteKgs;
    public $montoMultaBasculaRadar;
    public $estadoPago;
    public $tieneRegistro;
    public $observacion;
    public $fecha;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data) {
        $this->idContravencion = (isset($data['idContravencion'])) ? $data['idContravencion'] : null;
        $this->idConductor = (isset($data['idConductor'])) ? $data['idConductor'] : null;
        $this->idMunicipio = (isset($data['idMunicipio'])) ? $data['idMunicipio'] : null;       
        $this->idTipoVehiculo = (isset($data['idTipoVehiculo'])) ? $data['idTipoVehiculo'] : null;       
        $this->idMulta = (isset($data['idMulta'])) ? $data['idMulta'] : null;
        $this->km = (isset($data['km'])) ? $data['km'] : null;
        $this->numeroChapa = (isset($data['numeroChapa'])) ? $data['numeroChapa'] : null;
        $this->idUsuario = (isset($data['idUsuario'])) ? $data['idUsuario'] : null;
        $this->ruta = (isset($data['ruta'])) ? $data['ruta'] : null;
        $this->excedenteKgs = (isset($data['excedenteKgs'])) ? $data['excedenteKgs'] : null;
        $this->montoMultaBasculaRadar = (isset($data['montoMultaBasculaRadar'])) ? $data['montoMultaBasculaRadar'] : null;
        $this->estadoPago = (isset($data['estadoPago'])) ? $data['estadoPago'] : null;
        $this->tieneRegistro = (isset($data['tieneRegistro'])) ? $data['tieneRegistro'] : null;
        $this->observacion = (isset($data['observacion'])) ? $data['observacion'] : null;
        $this->fecha = (isset($data['fecha'])) ? $data['fecha'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
