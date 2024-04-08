<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class CiudadanoTable extends AbstractTableGateway
{
    protected $table = 'ciudadano';/*nombre de la tabla en nuestra base de datos*/

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Ciudadano());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCiudadano($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('idConductor' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }
    public function saveCiudadano(Ciudadano $ciudadano)
    {
        $data = array(
            'nombre' => $ciudadano->nombre,
            'apellido' => $ciudadano->apellido,
            'cedula' => $ciudadano->cedula,
            'direccion' => $ciudadano->direccion,
            'telefono' => $ciudadano->telefono,
             'registroNro' => $ciudadano->registroNro,
            'email' => $ciudadano->email,
        );
        $id = (int)$ciudadano->idConductor;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getCiudadano($id)) {
                $this->update($data, array('idConductor' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }
    public function deleteCiudadano($id)
    {
        $this->delete(array('idConductor' => $id));
    }
//
    
     public function ultimoIdGenerado()
    {
        $adapter = $this->adapter;/*adapter es la conexion a la BD*/
        $sSQL = "SELECT MAX(idConductor) AS maximo FROM ciudadano";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        
    
        return $resultado[0];
        
    }
}
