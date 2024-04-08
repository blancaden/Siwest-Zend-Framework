<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class TipovehiculoForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('tipovehiculo');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idTipoVehiculo',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'descripcion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Descripción',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-success form-control',/**para que el boton sea verde*/
            ),
        ));

    }
}
