<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contravencion\Model\Reporte;
use Contravencion\Form\MultasxrangoForm; //

class ReporteController extends AbstractActionController {

    protected $ReporteTable;
    protected $contravencionTable;

    public function getReporteTable()/* esta es nuestra conexión a la tabla */ {
        if (!$this->ReporteTable) {
            $sm = $this->getServiceLocator();
            $this->ReporteTable = $sm->get('Contravencion\Model\ReporteTable');
        }
        return $this->ReporteTable;
    }

    public function getContravencionTable()/* esta es nuestra conexión a la tabla */ {
        if (!$this->contravencionTable) {
            $sm = $this->getServiceLocator();
            $this->contravencionTable = $sm->get('Contravencion\Model\ContravencionTable');
        }
        return $this->contravencionTable;
    }

    public function getLogger() {
        $this->logger = new Logger();
        $this->logger->addWriter(new Writer\Stream('/log/cms_errors.log'));
        return $this->logger;
    }

//    public function indexAction() {
//        return new ViewModel(array(
//            'reportes' => $this->getReporteTable()->fetchAll(),
//        ));
//    }

    public function multasxrangoAction() {
        
        $buscar = array();
        $usuarios = $this->getContravencionTable()->obtenerUsuario();
        $error = NULL;
        $fechaInicio = NULL;
        $fechaFinal = NULL;
        $idUsuario = NULL;
        $estadoPago = NULL;
        $form = new MultasxrangoForm();
        $form->get('usuario')->setValueOptions($usuarios);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $fechaInicio = $request->getPost()->get('fechaInicio');
            $fechaFinal = $request->getPost()->get('fechaFinal');
            $idUsuario = $request->getPost()->get('usuario');
            $estadoPago = $request->getPost()->get('estadoPago');

            $buscar = $this->getContravencionTable()->buscarXrango($fechaInicio, $fechaFinal, $idUsuario,$estadoPago);
            
        }
  
        $form->get('fechaInicio')->setValue($fechaInicio);
        $form->get('fechaFinal')->setValue($fechaFinal);
        $form->get('usuario')->setValue($idUsuario);
        $form->get('estadoPago')->setValue($estadoPago);

        return array(
            'buscar' => $buscar,
            'form' => $form,
            'fechaInicio' =>$fechaInicio,'fechaFinal'=> $fechaFinal, 'usuario' => $idUsuario,'estadoPago' =>$estadoPago
        );
    }

    public function generarpdfAction() {
        $fechaInicio =  $this->params()->fromRoute('param1');
        $fechaFinal =  $this->params()->fromRoute('param2');
        $usuario =  $this->params()->fromRoute('param3');
        $estadoPago =  $this->params()->fromRoute('param4');
        
//        var_dump($fechaInicio);
//        var_dump($fechaFinal);
//        var_dump($usuario);
//        exit;
        $buscar = $this->getContravencionTable()->buscarXrango($fechaInicio, $fechaFinal, $usuario,$estadoPago);
         $viewModel = new ViewModel(array(
                   'buscar' =>$buscar,'fechaInicio' =>$fechaInicio,'fechaFinal' =>$fechaFinal,'usuario'=>$usuario,'estadoPago'=>$estadoPago
                ));
        $viewModel->setTerminal(true); // matar layout para usar modal
        return $viewModel;
    }

}
