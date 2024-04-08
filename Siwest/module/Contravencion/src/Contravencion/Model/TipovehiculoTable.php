<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class TipovehiculoTable extends AbstractTableGateway
{
    protected $table = 'tipovehiculo';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Tipovehiculo());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    public function getTipovehiculo($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('idTipoVehiculo' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }

    public function saveTipovehiculo(Tipovehiculo $tipovehiculo)
    {
        $data = array(
            'descripcion' => $tipovehiculo->descripcion,
        );

        $id = (int)$tipovehiculo->idTipoVehiculo;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getTipovehiculo($id)) {
                $this->update($data, array('idTipoVehiculo' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }

    public function deleteTipovehiculo($id)
    {
        $this->delete(array('idTipoVehiculo' => $id));
    }

}
