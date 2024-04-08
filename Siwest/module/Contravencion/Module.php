<?php

namespace Contravencion;

use Contravencion\Model\TipovehiculoTable;
use Contravencion\Model\CiudadanoTable;
use Contravencion\Model\MultasdescripcionTable;
use Contravencion\Model\MunicipioTable;
use Contravencion\Model \VehiculoTable;
use Contravencion\Model \ContravencionTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Contravencion\Model\TipovehiculoTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new TipovehiculoTable($dbAdapter);
                    return $table;
                },
                     'Contravencion\Model\CiudadanoTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CiudadanoTable($dbAdapter);
                    return $table; /**esto es lo que vamos a ir agregando una vez que agregamos nuevas tablas*/
                },
                     'Contravencion\Model\VehiculoTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new VehiculoTable($dbAdapter);
                    return $table; /**esto es lo que vamos a ir agregando una vez que agregamos nuevas tablas*/
                },
                      'Contravencion\Model\MunicipioTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new MunicipioTable($dbAdapter);
                    return $table; /**esto es lo que vamos a ir agregando una vez que agregamos nuevas tablas*/
                },
                      'Contravencion\Model\MultasdescripcionTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new MultasdescripcionTable($dbAdapter);
                    return $table; /**esto es lo que vamos a ir agregando una vez que agregamos nuevas tablas*/
                },
                          'Contravencion\Model\ContravencionTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContravencionTable($dbAdapter);
                    return $table; /**esto es lo que vamos a ir agregando una vez que agregamos nuevas tablas*/
                },
            ),
        );
    }    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}