<?php

namespace Contravencion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PagoController extends AbstractActionController {

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
            'pendientes' => $this->getContravencionTable()->pagosPendientes(),
            'pagados' => $this->getContravencionTable()->pagosPagados(),
        ));
    }

    public function confirmacionAction() {
        $idContravencion = (int) $this->params('id');
        $mostrarmultaSelec = $this->getContravencionTable()->obtenerMulta($idContravencion);
       
        $viewModel = new ViewModel(array(
            'mostrarmultaSelec' => $mostrarmultaSelec
        ));
        $viewModel->setTerminal(true); // matar layout para usar modal
        return $viewModel;
    }

    public function pagadoAction() {
        $idContravencion = (int) $this->params('id');
        $idUsuario = $this->zfcUserAuthentication()->getIdentity()->getId();
        $this->getContravencionTable()->realizarPago($idContravencion, $idUsuario);

        $detallePago = $this->getContravencionTable()->detallePago($idContravencion);
        $multa = $this->getContravencionTable()->multaDatos($idContravencion);
        $this->getContravencionTable()->enviarMailPago($multa, $detallePago);

        $ip = $_SERVER['REMOTE_ADDR'];
        $this->getServiceLocator()->get('Zend\Log')->info('Se realizó el pago a la contravención con ID:' . $idContravencion . ', por el usuario:' . $idUsuario . ',IP:' . $ip);
        return $this->redirect()->toRoute('pago', array('action' => 'index'));
    }

    public function pagadosAction() {
        return new ViewModel(array(
            'pagados' => $this->getContravencionTable()->pagosPagados(),
        ));
    }

}
