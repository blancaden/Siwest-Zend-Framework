<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class VehiculoTable extends AbstractTableGateway
{
    protected $table = 'vehiculo';/*nombre de la tabla en nuestra base de datos*/

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Vehiculo());
        $this->initialize();
    }

    public function fetchAll()
    {
       $adapter = $this->adapter;/*adapter es la conexion a la BD*/
        $sSQL = "Select *from vehiculo as v
                 join `tipovehiculo` as t on t.`idTipoVehiculo` = v.`idTipoVehiculo`;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        return $results;
    }
    public function getVehiculo($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('idVehiculo' => $id));//rowset nos permite recuperar registros
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }
    public function tipoVehiculo()
    {
        $adapter = $this->adapter;/*adapter es la conexion a la BD*/
        $sSQL = "Select t.`idTipoVehiculo`, t.`descripcion` from vehiculo as v
                 join `tipovehiculo` as t on t.`idTipoVehiculo` = v.`idTipoVehiculo`;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        foreach ($results as $prov) {
            $resultado[$prov['idTipoVehiculo']] = $prov['descripcion'];
        }
       /** var_dump($resultado);
        Exit;**/
        return $resultado;
    }
    public function saveVehiculo(Vehiculo $vehiculo)
    {
        $data = array(
            'nroChapa' => $vehiculo->nroChapa,
            'color' => $vehiculo->color,
            'modelo' => $vehiculo->modelo,
            'cedulaAutomotor' => $vehiculo->cedulaAutomotor,
            'propietario' => $vehiculo->propietario,
            'ci_Propietario' => $vehiculo->ci_Propietario,
            'idTipoVehiculo' => $vehiculo->idTipoVehiculo,            
        );
        $id = (int)$vehiculo->idVehiculo;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getVehiculo($id)) {
                $this->update($data, array('idVehiculo' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }
    public function deleteVehiculo($id)
    {
        $this->delete(array('idVehiculo' => $id));
    }

}
