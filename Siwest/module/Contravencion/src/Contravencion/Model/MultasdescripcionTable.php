<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class MultasdescripcionTable extends AbstractTableGateway
{
    protected $table = 'multasdescripcion';/*nombre de la tabla en nuestra base de datos*/

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Multasdescripcion());
        $this->initialize();
    }
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getMultasdescripcion($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('idMulta' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }
    public function saveMultasdescripcion(Multasdescripcion $multasdescripcion)
    {
        $data = array(
            'articuloNro' => $multasdescripcion->articuloNro,
            'descripcion' => $multasdescripcion->descripcion,
            'jornales' => $multasdescripcion->jornales,
            'monto' => $multasdescripcion->monto,         
        );
        $id = (int)$multasdescripcion->idMulta;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getMultasdescripcion($id)) {
                $this->update($data, array('idMulta' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }
    public function deleteMultasdescripcion($id)
    {
        $this->delete(array('idMulta' => $id));
    }

}
