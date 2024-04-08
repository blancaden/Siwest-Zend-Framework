<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Contravencion\Controller\Contravencion' => 'Contravencion\Controller\ContravencionController',
            'Contravencion\Controller\Tipovehiculo' => 'Contravencion\Controller\TipovehiculoController',
            'Contravencion\Controller\Ciudadano' => 'Contravencion\Controller\CiudadanoController',
            'Contravencion\Controller\Multasdescripcion' => 'Contravencion\Controller\MultasdescripcionController',
            'Contravencion\Controller\Municipio' => 'Contravencion\Controller\MunicipioController',
            'Contravencion\Controller\Vehiculo' => 'Contravencion\Controller\VehiculoController',
            'Contravencion\Controller\Pago' => 'Contravencion\Controller\PagoController',
            'Contravencion\Controller\Reporte' => 'Contravencion\Controller\ReporteController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contravencion' => array(/* esta es la ruta para acceder al modulo que en este caso es contravencion y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/contravencion[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    // 'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Contravencion',
                        'action' => 'index',
                    ),
                ),
            ),
            'tipovehiculo' => array(/* esta es la ruta para acceder al modulo que en este caso es tipovevhiculo y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/tipovehiculo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Tipovehiculo',
                        'action' => 'index',
                    ),
                ),
            ),
            'municipio' => array(/* esta es la ruta para acceder al modulo que en este caso es municipio y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/municipio[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Municipio',
                        'action' => 'index',
                    ),
                ),
            ),
            'multasdescripcion' => array(/* esta es la ruta para acceder al modulo que en este caso es multadescripcion y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/multasdescripcion[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Multasdescripcion',
                        'action' => 'index',
                    ),
                ),
            ),
            'vehiculo' => array(/* esta es la ruta para acceder al modulo que en este caso es vehiculo y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/vehiculo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Vehiculo',
                        'action' => 'index',
                    ),
                ),
            ),
            'ciudadano' => array(/* esta es la ruta para acceder al modulo que en este caso es ciudadano y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/ciudadano[/:action][/:id][/:param1]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'param1' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Ciudadano',
                        'action' => 'index',
                    ),
                ),
            ),
            'pago' => array(/* esta es la ruta para acceder al modulo que en este caso es pago y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/pago[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Pago',
                        'action' => 'index',
                    ),
                ),
            ),
            'reporte' => array(/* esta es la ruta para acceder al modulo que en este caso es reporte y que siempre debe ser todo en minuscula */
                'type' => 'segment',
                'options' => array(
                    'route' => '/reporte[/:action][/:id][/:param1][/:param2][/:param3][/:param4]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'param1' => '[a-zA-Z0-9-]+',
                        'param2' => '[a-zA-Z0-9_-]*',
                        'param3' => '[0-9]+',
                        'param4' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Contravencion\Controller\Reporte',
                        'action' => 'multasxrango',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'contravencion' => __DIR__ . '/../view',
        ),
    ),
);
