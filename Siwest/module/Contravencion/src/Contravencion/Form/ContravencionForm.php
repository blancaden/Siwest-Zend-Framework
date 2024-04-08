<?php

namespace Contravencion\Form;

use Zend\Form\Form;

class ContravencionForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('contravencion');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idContravencion',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
         $this->add(array(
            'name' => 'idConductor',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

       $this->add(array(
            'type' => 'Select',
            'name' => 'idTipoVehiculo',
            'attributes' => array(
                'class' => 'form-control ',
                  'required' => 'required',
            ),
            'options' => array(
                'empty_option' => 'Selectionar:',
                'label' => 'Tipo de Vehiculo',
            ),
        ));

        $this->add(array(
            'type' => 'Select',
            'name' => 'idMunicipio',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'empty_option' => 'Selectionar:',
                'label' => 'Municipio',
            ),
        ));

        
        $this->add(array(
            'name' => 'telefono',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Telefono',
            ),
        ));
        $this->add(array(
            'type' => 'Select',
            'name' => 'idMulta',
            'attributes' => array(
             'class' => 'form-control',
            ),
            'options' => array(
                'empty_option' => 'Selectionar:',
                'label' => 'Tipo de Multa',
            ),
        ));
        $this->add(array(
            'name' => 'km',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'KM',
            ),
        ));

        $this->add(array(
            'name' => 'numeroChapa',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Chapa Nro.',
            ),
        ));
      
        $this->add(array(
            'name' => 'ruta',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Ruta',
            ),
        ));

        $this->add(array(
            'name' => 'excedenteKgs',
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Excedente Kgs.',
            ),
        ));
        $this->add(array(
            'name' => 'montoMultaBasculaRadar',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Bascula/Radar',
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
                    'Pendiente' => 'Pendiente',
                    'Pagado' => 'Pagado',
                ),
                'label' => 'Estado de Pago',
            ),
        ));
        $this->add(array(
            'name' => 'tieneRegistro',
             'type' => 'Zend\Form\Element\Select',
            'attributes' => array( 
                'class' => 'form-control',
            ),
            'options' => array(
                'value_options' => array(
                    'Si' => 'Si',
                    'No' => 'No',
                ),
                'label' => 'Posee Registro',
            ),
        ));
          $this->add(array(
            'name' => 'observacion',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Observacion',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-success', /*             * para que el boton sea verde */
            ),
        ));
    }

}
