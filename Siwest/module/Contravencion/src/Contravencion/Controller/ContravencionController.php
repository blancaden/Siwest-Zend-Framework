<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Contravencion;
use Contravencion\Form\ContravencionForm;
use Contravencion\Form\BuscadorForm;

class ContravencionController extends AbstractActionController {

    protected $contravencionTable;
    protected $ciudadanoTable;

    public function getContravencionTable()/* esta es nuestra conexión a la tabla */ {
        if (!$this->contravencionTable) {
            $sm = $this->getServiceLocator();
            $this->contravencionTable = $sm->get('Contravencion\Model\ContravencionTable');
        }
        return $this->contravencionTable;
    }

    public function getCiudadanoTable()/* esta es nuestra conexión a la tabla */ {
        if (!$this->ciudadanoTable) {
            $sm = $this->getServiceLocator();
            $this->ciudadanoTable = $sm->get('Contravencion\Model\CiudadanoTable');
        }
        return $this->ciudadanoTable;
    }

    public function getLogger() {
        $this->logger = new Logger();
        $this->logger->addWriter(new Writer\Stream('/log/cms_errors.log'));
        return $this->logger;
    }

    public function indexAction() {
        return new ViewModel(array(
                    'contravenciones' => $this->getContravencionTable()->fetchAll(),
                ));
    }

    public function addAction() {
        $form = new ContravencionForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $form->get('idConductor')->setValueOptions($contravenciones);
        $request = $this->getRequest();
        $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
        $contravenciones = $this->getContravencionTable()->contravencion(); /* es la funcion tipoVehiculo la que vamos a usar para traer todos los tipos de vehiculos */
        if ($request->isPost()) {
            $contravencion = new Contravencion();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $contravencion->exchangeArray($form->getData());
                $this->getContravencionTable()->saveContravencion($contravencion, $idUsuario);

                
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Se agregó nueva contravencion:' . ', por el usuario:' . $idUsuario . ',IP:' . $ip);

                // Redirect to list of albums
                return $this->redirect()->toRoute('contravencion');
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('contravencion', array('action' => 'add'));
        }
        $contravencion = $this->getContravencionTable()->getContravencion($id); /* es la funcion de mi table * */

        $form = new ContravencionForm();
        $form->bind($contravencion);
        $form->get('submit')->setAttribute('value', 'Editar');
        $contravenciones = $this->getContravencionTable()->contravencion(); /* es la funcion tipoVehiculo la que vamos a usar para traer todos los tipos de vehiculos */
        $form->get('idConductor')->setValueOptions($contravenciones);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            //   $id = $form->get('idTipoVehiculo')->getValue();
            //   var_dump($id);
            //      exit;
            if ($form->isValid()) {
                $this->getContravencionTable()->saveContravencion($contravencion);

                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Se editó contravencion con ID:' . $id . ', por el usuario:' . $idUsuario . ',IP:' . $ip);
                // Redirect to list of albums
                return $this->redirect()->toRoute('contravencion', array('action' => 'index'));
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('contravencion');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getContravencionTable()->deleteContravencion($id);
                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Se editó contravencion con ID:' . $id . ', por el usuario:' . $idUsuario . ',IP:' . $ip);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('contravencion');
        }
        return array(
            'id' => $id,
            'contravencion' => $this->getContravencionTable()->getContravencion($id)
        );
    }

    public function buscadorAction() {

        $buscar = array();
        $error = NULL;
        $dato = NULL;
        $form = new BuscadorForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dato = $request->getPost()->get('buscador');

            $buscar = $this->getContravencionTable()->buscarRegistro($dato);
            if (count($buscar) == 0) {
                $error = 1;
            }
        }
        return array(
            'buscar' => $buscar,
            'form' => $form,
            'error' => $error, 'dato' => $dato
        );
    }

    public function addmultaAction() {
        $idConductor = (int) $this->params('id');
        $datosCiudadano = $this->getCiudadanoTable()->getCiudadano($idConductor);

        $form = new ContravencionForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $tipovehiculos = $this->getContravencionTable()->tipoVehiculo(); /* es la funcion tipoVehiculo la que vamos a usar para traer todos los tipos de vehiculos */
        $form->get('idTipoVehiculo')->setValueOptions($tipovehiculos);
        $tipomultas = $this->getContravencionTable()->tiposMulta();
        $form->get('idMulta')->setValueOptions($tipomultas);
        $municipios = $this->getContravencionTable()->municipios();
        $form->get('idMunicipio')->setValueOptions($municipios);
        $form->get('idConductor')->setValue($idConductor);
        $mostrarmulta = $this->getContravencionTable()->mostrarMultas($idConductor);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $contravencion = new Contravencion();
            $form->setData($request->getPost());
            $idConductor = $form->get('idConductor')->getValue();

            if ($form->isValid()) {
                $contravencion->exchangeArray($form->getData());
               
                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $this->getContravencionTable()->saveContravencion($contravencion, $idConductor, $idUsuario);
                $idContravencion = $this->getContravencionTable()->ultimoIdContravencion();
                $idCont = $idContravencion['maximo'];
                $multa = $this->getContravencionTable()->multaDatos($idCont);
                $datosCiudadano = $this->getCiudadanoTable()->getCiudadano($idConductor);
                $this->getContravencionTable()->enviarComprobanteMulta($multa);

                // Redirect to list of albums
                return $this->redirect()->toRoute('contravencion', array('action' => 'addmulta', 'id' => $idConductor));
            }
        }

        return array('form' => $form, 'mostrarmulta' => $mostrarmulta, 'idConductor' => $idConductor, 'datosCiudadano' => $datosCiudadano);
    }

    public function historialAction() {

        $idConductor = (int) $this->params('id');
        $datosCiudadano = $this->getCiudadanoTable()->getCiudadano($idConductor);
        $mostrarmulta = $this->getContravencionTable()->mostrarMultas($idConductor);

        $viewModel = new ViewModel(array(
                    'mostrarmulta' => $mostrarmulta,
                    'datosCiudadano' => $datosCiudadano
                ));
     //   $viewModel->setTerminal(true); // matar layout para usar modal
        return $viewModel;
    }

    public function comprobantemultaAction() {

        $idContravencion = (int) $this->params('id');
        $mostrarmulta = $this->getContravencionTable()->getContravencion($idContravencion);
        $idConductor = $mostrarmulta->idConductor;
        $datosCiudadano = $this->getCiudadanoTable()->getCiudadano($idConductor);

        $viewModel = new ViewModel(array(
                    'mostrarmulta' => $mostrarmulta,
                    'datosCiudadano' => $datosCiudadano,
                    'idContravencion' => $idContravencion
                ));
        $viewModel->setTerminal(true); // matar layout para usar modal
        return $viewModel;
    }

}
