<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class BuscadorForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('contravencion');

        $this->setAttribute('method', 'post');
//        $this->add(array(
//            'name' => 'idVehiculo',
//            'attributes' => array(
//                'type'  => 'hidden',
//            ),
//        ));

        $this->add(array(
            'name' => 'buscador',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control input-lg ',
                'placeholder' => 'Buscar por CI o Nro de Registro',
                'required' => 'required'
            ),
            'options' => array(
              //  'label' => 'Ingrese CI o Nro de Registro',
                
            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Buscar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary  btn-block',/**para que el boton sea azul*/
            ),
        ));

    }
}
