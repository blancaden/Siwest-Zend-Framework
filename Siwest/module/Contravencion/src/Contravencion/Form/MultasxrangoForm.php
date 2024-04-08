<?php

namespace Contravencion\Form;

use Zend\Form\Form;

class MultasxrangoForm extends Form {

    public function __construct($name = null) {
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
            'name' => 'fechaInicio',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'placeholder' => '',
                'required' => 'required',
                'id' => 'fechaInicio'
            ),
            'options' => array(
                'label' => 'Rango Inicial',
            ),
        ));
        $this->add(array(
            'name' => 'fechaFinal',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'placeholder' => '',
                //'required' => 'required',
                'id' => 'fechaFinal'
            ),
            'options' => array(
                'label' => 'Rango Final',
            ),
        ));
        $this->add(array(
            'name' => 'usuario',
            'type' => 'Select',
            'attributes' => array(
                'class' => 'form-control ',
                'placeholder' => '',
                'id' => 'usuario'
            //  'required' => 'required'
            ),
            'options' => array(
                'label' => 'Inspector',
            ),
        ));
        $this->add(array(
            'name' => 'estadoPago',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'value_options' => array(
                    'NULL' => '',
                    'Pendiente' => 'Pendiente',
                    'Pagado' => 'Pagado',
                ),
                'label' => 'Estado de Pago',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Buscar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary form-control  ', /*             * para que el boton sea azul */
            ),
        ));
    }

}
