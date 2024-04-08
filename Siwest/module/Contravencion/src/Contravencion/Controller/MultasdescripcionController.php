<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Multasdescripcion;
use Contravencion\Form\MultasdescripcionForm;

class MultasdescripcionController extends AbstractActionController
{
    protected $MultasdescripcionTable;
     public function getMultasdescripcionTable()/*esta es nuestra conexión a la tabla*/
    {
        if (!$this->MultasdescripcionTable) {
            $sm = $this->getServiceLocator();
            $this->MultasdescripcionTable = $sm->get('Contravencion\Model\MultasdescripcionTable');
        }
        return $this->MultasdescripcionTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'multasdesc' => $this->getMultasdescripcionTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new MultasdescripcionForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $multasdescripcion = new Multasdescripcion();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $multasdescripcion->exchangeArray($form->getData());
                $this->getMultasdescripcionTable()->saveMultasdescripcion($multasdescripcion);
                // Redirect to list of albums
                return $this->redirect()->toRoute('multasdescripcion');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('multasdescripcion', array('action'=>'add'));
        }
        $multasdescripcion = $this->getMultasdescripcionTable()->getMultasdescripcion($id); /*es la funcion de mi table **/

        $form = new MultasdescripcionForm();
        $form->bind($multasdescripcion);
        $form->get('submit')->setAttribute('value', 'Editar');
      //  $form->get('idTipoVehiculo')->setValue($id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
        //   $id = $form->get('idTipoVehiculo')->getValue();
        //   var_dump($id);
     //      exit;
            if ($form->isValid()) {
                $this->getMultasdescripcionTable()->saveMultasdescripcion($multasdescripcion);
                // Redirect to list of albums
               return $this->redirect()->toRoute('multasdescripcion', array('action'=>'index'));
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
            return $this->redirect()->toRoute('multasdescripcion');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getMultasdescripcionTable()->deleteMultasdescripcion($id);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('multasdescripcion');
        }
        return array(
            'id' => $id,
            'multasdescripcion' => $this->getMultasdescripcionTable()->getMultasdescripcion($id)
        );
    }
}
