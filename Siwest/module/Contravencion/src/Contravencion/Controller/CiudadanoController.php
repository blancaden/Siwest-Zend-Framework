<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Ciudadano;
use Contravencion\Form\CiudadanoForm;

class CiudadanoController extends AbstractActionController {

    protected $CiudadanoTable;

    public function getCiudadanoTable()/* esta es nuestra conexión a la tabla */ {
        if (!$this->CiudadanoTable) {
            $sm = $this->getServiceLocator();
            $this->CiudadanoTable = $sm->get('Contravencion\Model\CiudadanoTable');
        }
        return $this->CiudadanoTable;
    }

    public function getLogger() {
        $this->logger = new Logger();
        $this->logger->addWriter(new Writer\Stream('/log/cms_errors.log'));
        return $this->logger;
    }

    public function indexAction() {
        return new ViewModel(array(
                    'ciudadanos' => $this->getCiudadanoTable()->fetchAll(),
                ));
    }

    public function addAction() {
         $cedulaBuscada = (int) $this->params('param1');
        $form = new CiudadanoForm();
        $form->get('cedula')->setValue($cedulaBuscada);
        $form->get('submit')->setAttribute('value', 'Agregar');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ciudadano = new Ciudadano();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $ciudadano->exchangeArray($form->getData());
                $this->getCiudadanoTable()->saveCiudadano($ciudadano);
                $idCiudadano = $this->getCiudadanoTable()->ultimoIdGenerado();
                $id = $idCiudadano['maximo'];

                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Se agregó el ciudadano con ID:' . $id . ', por el usuario:' . $idUsuario . ',IP:' . $ip);
                // Redirect to list of albums

                return $this->redirect()->toRoute('contravencion', array('action' => 'addmulta', 'id' => $id));
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('ciudadano', array('action' => 'add'));
        }
        $ciudadano = $this->getCiudadanoTable()->getCiudadano($id); /* es la funcion de mi table * */

        $form = new CiudadanoForm();
        $form->bind($ciudadano);
        $form->get('submit')->setAttribute('value', 'Editar');
        //  $form->get('idTipoVehiculo')->setValue($id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            //   $id = $form->get('idTipoVehiculo')->getValue();
            //   var_dump($id);
            //      exit;
            if ($form->isValid()) {
                $this->getCiudadanoTable()->saveCiudadano($ciudadano);
                
                
                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $usuario = 
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Datos editados del ciudadano con ID:' . $id . ', por el usuario:' . $idUsuario . ',IP:' . $ip);
                // Redirect to list of albums
               // return $this->redirect()->toRoute('ciudadano', array('action' => 'index'));
                 return $this->redirect()->toRoute('contravencion', array('action' => 'addmulta', 'id' => $id));
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
            return $this->redirect()->toRoute('ciudadano');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getCiudadanoTable()->deleteCiudadano($id);
                
                $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
                $usuario = 
                $ip = $_SERVER['REMOTE_ADDR'];
                $this->getServiceLocator()->get('Zend\Log')->info('Se elimino registros del ciudadano con ID:' . $id . ', por el usuario:' . $idUsuario . ',IP:' . $ip);

            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('ciudadano');
        }
        return array(
            'id' => $id,
            'ciudadano' => $this->getCiudadanoTable()->getCiudadano($id)
        );
    }

}
