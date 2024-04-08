<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class MunicipioTable extends AbstractTableGateway
{
    protected $table = 'municipio';/*nombre de la tabla en nuestra base de datos*/

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Municipio());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getMunicipio($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('idMunicipio' => $id));/**mediante el rowset recuperamos datos, aqui segun el id que hayamos consultado y si no lo encuentra emite un mensaje**/
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }
    public function saveMunicipio(Municipio $municipio)
    {
        $data = array(
            'municipio' => $municipio->municipio,
        );
        $id = (int)$municipio->idMunicipio;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getMunicipio($id)) {
                $this->update($data, array('idMunicipio' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }
    public function deleteMunicipio($id)
    {
        $this->delete(array('idMunicipio' => $id));
    }

}
