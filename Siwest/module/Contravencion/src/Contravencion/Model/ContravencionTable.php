<?php

namespace Contravencion\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class ContravencionTable extends AbstractTableGateway {

    protected $table = 'contravencion'; /* nombre de la tabla en nuestra base de datos */

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Contravencion());
        $this->initialize();
    }

    public function fetchAll() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "Select t.`idTipoVehiculo`, t.`descripcion` from vehiculo as v
                 join `tipovehiculo` as t on t.`idTipoVehiculo` = v.`idTipoVehiculo`;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        return $results;
    }

    public function getContravencion($id) {
        $id = (int) $id;
        $rowset = $this->select(array('idContravencion' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("No encuentra la Fila $id");
        }
        return $row;
    }

    public function contravencion() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "Select t.`idTipoVehiculo`, t.`descripcion` from vehiculo as v
                 join `tipovehiculo` as t on t.`idTipoVehiculo` = v.`idTipoVehiculo`;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        foreach ($results as $prov) {
            $resultado[$prov['idTipoVehiculo']] = $prov['descripcion'];
        }
        /** var_dump($resultado);
          Exit;* */
        return $resultado;
    }

    public function saveContravencion(Contravencion $contravencion, $idConductor, $idUsuario) {
        $data = array(
            'idConductor' => $idConductor,
            'idMunicipio' => $contravencion->idMunicipio,
            'idTipoVehiculo' => $contravencion->idTipoVehiculo,
            'idMulta' => $contravencion->idMulta,
            'km' => $contravencion->km,
            'numeroChapa' => $contravencion->numeroChapa,
            'ruta' => $contravencion->ruta,
            'excedenteKgs' => $contravencion->excedenteKgs,
            'montoMultaBasculaRadar' => $contravencion->montoMultaBasculaRadar,
            'estadoPago' => $contravencion->estadoPago,
            'tieneRegistro' => $contravencion->tieneRegistro,
            'observacion' => $contravencion->observacion,
            'idUsuario' => $idUsuario,
        );
        $id = (int) $contravencion->idContravencion;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getContravencion($id)) {
                $this->update($data, array('idContravencion' => $id));
            } else {
                throw new \Exception('No encuentra el id');
            }
        }
    }

    public function deleteCiudadano($id) {
        $this->delete(array('idContravencion' => $id));
    }

//
    public function multaDatos($idContravencion) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
         SELECT c.idContravencion, t.descripcion as tipvehi , m.`municipio`, c.ruta, c.km, c.numeroChapa,
mu.`descripcion` as multa, c.`estadoPago`, c.fecha, c.observacion,m.idMunicipio,
ciu.`nombre`,ciu.`apellido`,ciu.`direccion`, ciu.`cedula`, ciu.`email`, ciu.`registroNro`, mu.monto, c.`idConductor`, mu.`articuloNro`,
u.`display_name`
FROM `contravencion` AS c 
JOIN `tipovehiculo` as t   on t.`idTipoVehiculo` = c.`idTipoVehiculo`
JOIN `municipio` as m on m.`idMunicipio` = c.`idMunicipio`
JOIN `multasdescripcion` as mu on mu.`idMulta` = c.`idMulta`
JOIN `ciudadano` AS ciu ON ciu.`idConductor` = c.`idConductor`
lEFT JOIN user AS u ON u.user_id = c.`idUsuario`
WHERE c.idContravencion = $idContravencion ";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();


        return $resultado[0];
    }

    public function mostrarMultas($idConductor) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
         SELECT c.idContravencion, t.descripcion as tipvehi , m.`municipio`,
mu.`descripcion` as multa, c.`estadoPago`, c.fecha, c.observacion,
ciu.`nombre`,ciu.`apellido`, ciu.`cedula`, ciu.`registroNro`
,u.`display_name`
FROM `contravencion` AS c 
JOIN `tipovehiculo` as t   on t.`idTipoVehiculo` = c.`idTipoVehiculo`
JOIN `municipio` as m on m.`idMunicipio` = c.`idMunicipio`
JOIN `multasdescripcion` as mu on mu.`idMulta` = c.`idMulta`
JOIN `ciudadano` AS ciu ON ciu.`idConductor` = c.`idConductor`
LEFT JOIN `user` AS u ON u.`user_id` = c.`idUsuario`
WHERE ciu.idConductor = $idConductor ORDER BY c.estadoPago,c.fecha DESC";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
//        $resource = $results->getResource();
//        $resultado = $resource->fetchAll();


        return $results;
    }

    public function buscarRegistro($dato) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "SELECT * FROM ciudadano AS c WHERE c.cedula = '$dato' OR c.registroNro = '$dato' ";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();

        return $results;
    }
    public function obtenerUsuario() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "SELECT user_id, display_name from `user`";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        $resultado[0] = '';
        foreach ($results as $usuario) {
            $resultado[$usuario['user_id']] = $usuario['display_name'];
        }
        /** var_dump($resultado);
          Exit;* */
        return $resultado;
    }
    
    public function buscarXrango($fechaInicio,$fechaFinal,$idUsuario,$estadoPago) {
        if(!$idUsuario){
            $idUsuario = 'Null';
        }
         if($estadoPago == 'NULL'){
            $estadoPago = '';
        }
       
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "CALL buscadorXrango('$fechaInicio','$fechaFinal',$idUsuario,'$estadoPago') ";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();

        return $results;
    }

    public function tipoVehiculo() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "Select t.`idTipoVehiculo`, t.`descripcion` From `tipovehiculo` as t;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        foreach ($results as $prov) {
            $resultado[$prov['idTipoVehiculo']] = $prov['descripcion'];
        }
        /** var_dump($resultado);
          Exit;* */
        return $resultado;
    }

    public function tiposMulta() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "Select t.`idMulta`, t.`descripcion` from multasdescripcion as t;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        foreach ($results as $prov) {
            $resultado[$prov['idMulta']] = $prov['descripcion'];
        }
        /** var_dump($resultado);
          Exit;* */
        return $resultado;
    }

    public function municipios() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "Select t.`idMunicipio`, t.`municipio` from municipio as t;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resultado = NULL;
        foreach ($results as $prov) {
            $resultado[$prov['idMunicipio']] = $prov['municipio'];
        }
        /** var_dump($resultado);
          Exit;* */
        return $resultado;
    }

    public function pagosPendientes() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
            SELECT * FROM contravencion AS co
            JOIN ciudadano AS c  ON c.idConductor = co.idConductor 
            WHERE estadoPago = 'Pendiente';";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        return $resultado;
    }

    public function detallePago($idContravencion) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
            SELECT * FROM pago AS p JOIN user AS u ON u.user_id = p.idUsuario WHERE idContravencion = $idContravencion";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        return $resultado[0];
    }
     public function altaContravencion($idContravencion) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
            SELECT * FROM contravencion AS c JOIN user AS u ON u.user_id = c.idUsuario WHERE idContravencion = $idContravencion";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        return $resultado[0];
    }

    public function pagosPagados() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
            SELECT * FROM contravencion AS co
            JOIN ciudadano AS c  ON c.idConductor = co.idConductor 
            JOIN pago AS p ON p.idContravencion = co.idContravencion
            WHERE estadoPago = 'Pagado' ORDER BY p.fechaPago DESC;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        return $resultado;
    }

    public function obtenerMulta($idContravencion) {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "
            SELECT * FROM contravencion AS co
            JOIN ciudadano AS c  ON c.idConductor = co.idConductor 
            JOIN multasdescripcion AS md ON md.idMulta = co.idMulta  
            WHERE idContravencion = $idContravencion;";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();
        return $resultado[0];
    }

    public function realizarPago($idContravencion, $idUsuario) {

        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = " CALL realizarPago($idContravencion,$idUsuario)";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        return $results;
    }

    public function ultimoIdContravencion() {
        $adapter = $this->adapter; /* adapter es la conexion a la BD */
        $sSQL = "SELECT MAX(idContravencion) AS maximo FROM contravencion";
        $statement = $adapter->createStatement($sSQL);
        $results = $statement->execute();
        $resource = $results->getResource();
        $resultado = $resource->fetchAll();


        return $resultado[0];
    }

    function enviarComprobanteMulta($mostrarmulta) {
        $html = '';
        $html .= '<div style="widht: 40%">
        <table>
            <tr>
                <td style="margin:5%; margin-top: 0%; width:80px"><img src="https://lh3.googleusercontent.com/-Ozc5BapYdts/U8wsazhgEjI/AAAAAAAAAB4/Itwh78y4Pgo/s70-no/paraguay1.png' . '" align="left" /></td>
                <td><span style="font-size: 18px; font-weight: bold">MINISTERIO DE OBRAS PUBLICAS Y COMUNICACIONES</span><br>
                    <span>Direccion de Control y Seguridad de Transito</span><br>
                    <b>POLICIA CAMINERA</b><br>
                    <span><b>Telefono:</b> 532-689 - 584257</span><br>
                </td>
                <td align="right" style="margin:3%; font-size:16; width:80px"><b>NRO BOLETA:</b><br> ' . $mostrarmulta['idContravencion'] . '</td>
            </tr>  
        </table><hr>';
        $html .= '<h3 align="center"> BOLETA DE CONTRAVENCION</h3><br>';
        $html .= '<span style="margin-left:0%"><b>Conductor: </b>' . $mostrarmulta['nombre'] . $mostrarmulta['apellido'] . '</span>' . ' <span style="margin-left:3%"><b>C.I: </b>' . $mostrarmulta['cedula'] . '</span>' . ' <span style="margin-left:3%"><b>Nro Registro: </b>' . $mostrarmulta['registroNro'] . '</span>' . ' <span style="margin-left:3%"><b>Municipio:</b>' . $mostrarmulta['municipio'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Veh&iacute;culo: </b>' . $mostrarmulta['tipvehi'] . '</span>' . ' <span style="margin-left:0%"><b><br>Chapa Nro: </b>' . $mostrarmulta['numeroChapa'] . '</span>' . '<span style="margin-left:3%"><b>Contravenci&oacute;n: </b>' . $mostrarmulta['multa'] . '</span>' . ' <span style="margin-left:3%"><b>km:</b> ' . $mostrarmulta['km'] . '</span>' . ' <span style="margin-left:3%"><b>Ruta:</b> ' . $mostrarmulta['ruta'] . '</span>' . ' <span style="margin-left:3%"><b><br>Fecha-Hora: </b> ' . $mostrarmulta['fecha'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Monto: </b>' . $mostrarmulta['monto'] . '</span>';
        $html .= '<p><b>Queda Ud. notificado que dentro de los 5 d&iacute;as h&aacute;biles deber&aacute; presentarse a la policia caminera de: ' . $mostrarmulta['idMunicipio'] . ' bajo apercibimiento por lo dispuesto en el Articulo 208
        del decreto Ley Nro: 22094 Reglamento general de Tr&aacute;nsito Caminero</b>.</p>';
        
        
        $html .= '<span style="margin-left:0%"><b>Conductor: </b>'  . $mostrarmulta['fecha'] . '</span><br>';
        $html .= '<span align="right"><b>Inspector: </b>' . $mostrarmulta['display_name']. '</span><br>';
        $html .= '<span style="font-size:20px"><b>V&aacute;lido por Cinco (5) d&iacute;as h&aacute;biles<b></span></div>';

        $bodyPart = new \Zend\Mime\Message();
        $bodyMessage = new \Zend\Mime\Part($html);
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));

        $message = new \Zend\Mail\Message();
        $message->setBody($bodyPart);
        $message->setFrom('camineraparaguay@gmail.com', 'Policia Caminera');
        //    $message->addTo('maricel.machu@gmail.com', 'Maricel Maldonado');
        $message->addTo('blankdgonzfigue@gmail.com', 'Blanca Gonzalez');
        $message->addTo($mostrarmulta['email'], $mostrarmulta['nombre'] . ' ' . $mostrarmulta['apellido']);
        $message->setSubject('Notificación de Multa');


        //   $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();
//        $smtpOptions->setHost('smtp.gmail.com')
//                
//                ->setConnectionClass('login')
//                ->setName('smtp.gmail.com')
//                ->setConnectionConfig(array(
//                    'username' => "camineraparaguay@gmail.com",
//                    'password' => 'pycam123',
//                    'ssl' => 'tls',
//                        )
//        );
        $smtpOptions = new SmtpOptions(array(
            'host' => 'smtp.gmail.com',
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => 'camineraparaguay@gmail.com',
                'password' => 'pycam123'
            ),
            'port' => 587,
        ));

        $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
        $transport->send($message);
    }

    function enviarMailPago($mostrarmulta, $detallePago) {
//           echo '<pre>';
//        print_r($datosCiudadano);
//        echo '<pre>';
//         echo '<pre>';
//        print_r($mostrarmulta);
//        echo '<pre>';
//         echo '<pre>';
//        print_r($detallePago);
//        echo '<pre>';
//exit;
        $html = '';
        $html .= '<div style="widht: 40%">
        <table>
            <tr>
                <td style="margin:5%; margin-top: 0%; width:80px"><img src="https://lh3.googleusercontent.com/-Ozc5BapYdts/U8wsazhgEjI/AAAAAAAAAB4/Itwh78y4Pgo/s70-no/paraguay1.png' . '" align="left" /></td>
                <td><span style="font-size: 18px; font-weight: bold">MINISTERIO DE OBRAS PUBLICAS Y COMUNICACIONES</span><br>
                    <span>Direccion de Control y Seguridad de Transito</span><br>
                    <b>POLICIA CAMINERA</b><br>
                    <span><b>Telefono:</b> 532-689 - 584256</span><br>
                </td>
                <td align="right" style="margin:3%; font-size:16; width:110px"><b>NRO BOLETA:</b><br> ' . $detallePago['idPago'] . '</td>
            </tr>  
        </table><hr>';
        $html .= '<h3 align="center"> COMPROBANTE DE INGRESO</h3>';
        $html .= '<span style="margin-left:3%"><b>Nombre del Conductor y/o Raz&oacute;n Social: </b>' . $mostrarmulta['nombre'] . $mostrarmulta['apellido'] . '</span>';
        $html .= ' <span style="margin-left:3%"><b>Domicilio: </b>' . $mostrarmulta['direccion'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Fecha Sanci&oacute;n: </b>' . $mostrarmulta['fecha'] . '</span><br>';

        $html .='<div style="border: 1px solid #000; padding:1%;">';
        $html .= '<span style="margin-left:0%"><b>Datos del Vehiculo: </b>' . $mostrarmulta['tipvehi'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Chapa Nro: </b>' . $mostrarmulta['numeroChapa'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Municipio: </b>' . $mostrarmulta['municipio'] . '</span>';
        $html .= '<span style="margin-left:3%"><b><br>Boleta de Contravenci&oacute;n Nro: </b>' . $mostrarmulta['idContravencion'] . '</span>';
        $html .= '<span style="margin-left:3%"><b>Articulos: </b>' . $mostrarmulta['articuloNro'] . '</span><br>';
        $html .= '<div style="float:left"><b>Disposici&oacute;n Legal<br> Ley Nro. 22094/47 </b>' . '</div><div style="clear:both"></div></div>';
        $html .= '<table style="width:60%"><tr>'
                . '<th style="border: 1px solid #0000; background-color: #5d8b3d; color: white;padding:1%">Concepto</th>'
                . '<th style="border: 1px solid #0000; background-color: #5d8b3d; color: white;padding:1%">Importe</th>'
                . '</tr><tr>'
                . '<td style="border: 1px solid #000;padding:1%">' . $mostrarmulta['multa'] . '</td>'
                . '<td style="border: 1px solid #000;padding:1%">' . $mostrarmulta['monto'] . '</td>'
                . '</tr>'
                . '</table><div align="right"><b>Cajero: </b>'.$detallePago['display_name'].' </div><div style="clear:both"></div>';
        $html .= '<div align="right"><b>Asunci&oacute;n, ' . date('d') . ' de ' . $this->obtenerMes(date('m')) . ' de ' . date('Y') . '</b>' . '</div><br>';

        $bodyPart = new \Zend\Mime\Message();
        $bodyMessage = new \Zend\Mime\Part($html);
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));

        $message = new \Zend\Mail\Message();
        $message->setBody($bodyPart);
        $message->setFrom('camineraparaguay@gmail.com', 'Policia Caminera');
        //  $message->addTo('maricel.machu@gmail.com', 'Maricel Maldonado');
        $message->addTo('blankdgonzfigue@gmail.com', 'Blanca Gonzalez');
        $message->addTo($mostrarmulta['email'], $mostrarmulta['nombre'] . ' ' . $mostrarmulta['apellido']);
        $message->setSubject('Comprobante Pago de Multa');

        $smtpOptions = new SmtpOptions(array(
            'host' => 'smtp.gmail.com',
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => 'camineraparaguay@gmail.com',
                'password' => 'pycam123'
            ),
            'port' => 587,
        ));


        $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
        $transport->send($message);
    }

    public function obtenerMes($nroMes) {
        if ($nroMes == 01) {
            return 'Enero';
        } elseif ($nroMes == 02) {
            return 'Febrero';
        } elseif ($nroMes == 03) {
            return 'Marzo';
        } elseif ($nroMes == 04) {
            return 'Abril';
        } elseif ($nroMes == 05) {
            return 'Mayo';
        } elseif ($nroMes == 06) {
            return 'Junio';
        } elseif ($nroMes == 07) {
            return 'Julio';
        } elseif ($nroMes == '08') {
            return 'Agosto';
        } elseif ($nroMes == '09') {
            return 'Septiembre';
        } elseif ($nroMes == 10) {
            return 'Octubre';
        } elseif ($nroMes == 11) {
            return 'Noviembre';
        } elseif ($nroMes == 12) {
            return 'Diciembre';
        }
    }

}
