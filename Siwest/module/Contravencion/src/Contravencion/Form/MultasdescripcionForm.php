<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class MultasdescripcionForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('multasdescripcion');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idMulta',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'articuloNro',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Articulo',
            ),
        ));
        
        $this->add(array(
            'name' => 'descripcion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Descripcion',
            ),
        ));
        
        $this->add(array(
            'name' => 'jornales',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Jornales',
            ),
        ));
        
        $this->add(array(
            'name' => 'monto',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Monto',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary form-control',/**para que el boton sea verde*/
            ),
        ));

    }
}
