<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class VehiculoForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('vehiculo');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idVehiculo',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nroChapa',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Chapa Nro.',
            ),
        ));
        
        $this->add(array(
            'name' => 'color',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Color',
            ),
        ));
        
        $this->add(array(
            'name' => 'modelo',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Modelo',
            ),
        ));
        
        $this->add(array(
            'name' => 'cedulaAutomotor',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Ced.Automotor',
            ),
        ));
        
        $this->add(array(
            'name' => 'propietario',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Propietario',
            ),
        ));
        $this->add(array(
            'name' => 'ci_Propietario',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'CI.Propietario',
            ),
        ));
        $this->add(array(
            'type'  => 'Select',
            'name' => 'idTipoVehiculo',
            'attributes' => array(
            
            ),
            'options' => array(
                'empty_option'=> 'Selectionar:',
                'label' => 'Tipo Vehiculo',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-success',/**para que el boton sea verde*/
            ),
        ));

    }
}
