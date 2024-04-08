<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Municipio;
use Contravencion\Form\MunicipioForm;

class MunicipioController extends AbstractActionController
{
    protected $municipioTable;
     public function getMunicipioTable()
    {
        if (!$this->municipioTable) {
            $sm = $this->getServiceLocator();
            $this->municipioTable = $sm->get('Contravencion\Model\MunicipioTable');
        }
        return $this->municipioTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'municipios' => $this->getMunicipioTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new MunicipioForm();
        $form->get('submit')->setAttribute('value', 'Agregar');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $municipio = new Municipio();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $municipio->exchangeArray($form->getData());
                $this->getMunicipioTable()->saveMunicipio($municipio);

                // Redirect to list of albums
                return $this->redirect()->toRoute('municipio');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('municipio', array('action'=>'add'));
        }
        $municipio = $this->getMunicipioTable()->getMunicipio($id); /*es la funcion de mi table **/

        $form = new MunicipioForm();
        $form->bind($municipio);
        $form->get('submit')->setAttribute('value', 'Modificar');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getMunicipioTable()->saveMunicipio($municipio);
                // Redirect to list of albums
               return $this->redirect()->toRoute('municipio', array('action'=>'index'));
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
            return $this->redirect()->toRoute('municipio');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getMunicipioTable()->deleteMunicipio($id);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('municipio');
        }
        return array(
            'id' => $id,
            'municipio' => $this->getMunicipioTable()->getMunicipio($id)
        );
    }
       
}
