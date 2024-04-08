<?php

return array(
    'bjyauthorize' => array(
        //establecer el papel de la huésped por defecto (debe estar definido en un proveedor de funciones)
        'default_role' => 'guest',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
        'unauthorized_strategy' => 'BjyAuthorize\View\UnauthorizedStrategy',
        'role_providers' => array(
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user' => array('children' => array(
                        'admin' => array(),
                    )),
            ),
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table' => 'user_role',
                'role_id_field' => 'role_id',
                'parent_role_field' => 'parent',
            ),
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'pants' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    array(array('guest', 'user'), 'pants', 'wear')
                ),
                'deny' => array(
                ),
            ),
        ),
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'index', 'action' => 'index', 'roles' => array('guest', 'user', 'admin',)),
                array('controller' => 'zfcuser', 'roles' => array('admin', 'guest', 'user')),
                array('controller' => 'Contravencion\Controller\Ciudadano', 'action' => 'index', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Ciudadano', 'action' => 'add', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Ciudadano', 'action' => 'edit', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Ciudadano', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'index', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'add', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'edit', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'buscador', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'addmulta', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'historial', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Contravencion', 'action' => 'comprobantemulta', 'roles' => array('admin', 'contravencion')),
                array('controller' => 'Contravencion\Controller\Multasdescripcion', 'action' => 'index', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Multasdescripcion', 'action' => 'add', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Multasdescripcion', 'action' => 'edit', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Multasdescripcion', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Municipio', 'action' => 'index', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Municipio', 'action' => 'add', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Municipio', 'action' => 'edit', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Municipio', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Pago', 'action' => 'index', 'roles' => array('admin', 'pagos')),
                array('controller' => 'Contravencion\Controller\Pago', 'action' => 'confirmacion', 'roles' => array('admin', 'pagos')),
                array('controller' => 'Contravencion\Controller\Pago', 'action' => 'pagado', 'roles' => array('admin', 'pagos')),
                array('controller' => 'Contravencion\Controller\Pago', 'action' => 'pagados', 'roles' => array('admin', 'pagos')),
                array('controller' => 'Contravencion\Controller\Tipovehiculo', 'action' => 'index', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Tipovehiculo', 'action' => 'add', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Tipovehiculo', 'action' => 'edit', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Tipovehiculo', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Vehiculo', 'action' => 'index', 'roles' => array('user', 'admin')),
                array('controller' => 'Contravencion\Controller\Vehiculo', 'action' => 'add', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Vehiculo', 'action' => 'edit', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Vehiculo', 'action' => 'delete', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Reporte', 'action' => 'multasxrango', 'roles' => array('admin')),
                array('controller' => 'Contravencion\Controller\Reporte', 'action' => 'generarpdf', 'roles' => array('admin')),
            ),
            'BjyAuthorize\Guard\Route' => array(array('route' => 'application', 'roles' => array('user',)),
                array('route' => 'zfcuser', 'roles' => array('user', 'guest', 'admin')),
                array('route' => 'zfcuser/logout', 'roles' => array('user', 'guest', 'admin')),
                array('route' => 'zfcuser/authenticate', 'roles' => array('user', 'guest', 'admin',)),
                array('route' => 'zfcuser/login', 'roles' => array('user', 'guest', 'admin')),
                array('route' => 'zfcuser/resetpass', 'roles' => array('admin',)),
                array('route' => 'zfcuser/changepassword', 'roles' => array('user', 'admin')),
                array('route' => 'zfcuser/register', 'roles' => array('admin')),
                array('route' => 'home', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'ciudadano', 'roles' => array('admin', 'contravencion')),
                array('route' => 'multasdescripcion', 'roles' => array('admin')),
                array('route' => 'municipio', 'roles' => array('admin')),
                array('route' => 'pago', 'roles' => array('admin', 'pagos')),
                array('route' => 'tipovehiculo', 'roles' => array('admin')),
                array('route' => 'vehiculo', 'roles' => array('admin')),
                array('route' => 'contravencion', 'roles' => array('admin', 'contravencion')),
                array('route' => 'reporte', 'roles' => array('admin', 'contravencion')),
            ),
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ),
    ),
);

