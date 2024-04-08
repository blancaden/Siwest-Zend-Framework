<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Tipovehiculo;
use Contravencion\Form\TipovehiculoForm;

class TipovehiculoController extends AbstractActionController
{
    protected $tipovehiculoTable;
     public function getTipovehiculoTable()
    {
        if (!$this->tipovehiculoTable) {
            $sm = $this->getServiceLocator();
            $this->tipovehiculoTable = $sm->get('Contravencion\Model\TipovehiculoTable');
        }
        return $this->tipovehiculoTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'tiposdevehiculos' => $this->getTipovehiculoTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new TipoVehiculoForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $tipovehiculo = new Tipovehiculo();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $tipovehiculo->exchangeArray($form->getData());
                $this->getTipovehiculoTable()->saveTipovehiculo($tipovehiculo);

                // Redirect to list of albums
                return $this->redirect()->toRoute('tipovehiculo');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('tipovehiculo', array('action'=>'add'));
        }
        $tipovehiculo = $this->getTipovehiculoTable()->getTipovehiculo($id); /*es la funcion de mi table **/

        $form = new TipovehiculoForm();
        $form->bind($tipovehiculo);
        $form->get('submit')->setAttribute('value', 'Editar');
      //  $form->get('idTipoVehiculo')->setValue($id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
        //   $id = $form->get('idTipoVehiculo')->getValue();
        //   var_dump($id);
     //      exit;
            if ($form->isValid()) {
                $this->getTipovehiculoTable()->saveTipovehiculo($tipovehiculo);
                // Redirect to list of albums
               return $this->redirect()->toRoute('tipovehiculo', array('action'=>'index'));
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('tipovehiculo');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getTipovehiculoTable()->deleteTipovehiculo($id);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('tipovehiculo');
        }
        return array(
            'id' => $id,
            'tipovehiculo' => $this->getTipovehiculoTable()->getTipovehiculo($id)
        );
    }
       
}
