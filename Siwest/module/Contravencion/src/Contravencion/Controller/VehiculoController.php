<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Vehiculo;
use Contravencion\Form\VehiculoForm;
class VehiculoController extends AbstractActionController
{
    protected $VehiculoTable;
     public function getVehiculoTable()/*esta es nuestra conexión a la tabla*/
    {
        if (!$this->VehiculoTable) {
            $sm = $this->getServiceLocator();
            $this->VehiculoTable = $sm->get('Contravencion\Model\VehiculoTable');
        }
        return $this->VehiculoTable;
    }
    public function indexAction()
    {
        return new ViewModel(array(
            'vehiculos' => $this->getVehiculoTable()->fetchAll(),
        ));
    }
    public function addAction()
    {
        $form = new VehiculoForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $tiposvehiculos = $this->getVehiculoTable()->tipoVehiculo(); /*es la funcion tipoVehiculo la que vamos a usar para traer todos los tipos de vehiculos*/ 
        $form->get('idTipoVehiculo')->setValueOptions($tiposvehiculos);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $vehiculo = new Vehiculo();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $vehiculo->exchangeArray($form->getData());
                $this->getVehiculoTable()->saveVehiculo($vehiculo);
                // Redirect to list of albums
                return $this->redirect()->toRoute('vehiculo');
            }
        }

        return array('form' => $form);
    }
    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('vehiculo', array('action'=>'add'));
        }
        $vehiculo = $this->getVehiculoTable()->getVehiculo($id); /*es la funcion de mi table **/
        $form = new VehiculoForm();/* para inicializar el formulario*/
        $form->bind($vehiculo); /*solo se usa en el edit..*/
        $form->get('submit')->setAttribute('value', 'Editar');
        $tiposvehiculos = $this->getVehiculoTable()->tipoVehiculo(); /*es la funcion tipoVehiculo la que vamos a usar para traer todos los tipos de vehiculos*/ 
        $form->get('idTipoVehiculo')->setValueOptions($tiposvehiculos);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
     
            if ($form->isValid()) {
                $this->getVehiculoTable()->saveVehiculo($vehiculo);
                // Redirect to list of albums
               return $this->redirect()->toRoute('vehiculo', array('action'=>'index'));
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
            return $this->redirect()->toRoute('vehiculo');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getVehiculoTable()->deleteVehiculo($id);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('vehiculo');
        }
        return array(
            'id' => $id,
            'vehiculo' => $this->getVehiculoTable()->getVehiculo($id)
        );
    }
       
}
