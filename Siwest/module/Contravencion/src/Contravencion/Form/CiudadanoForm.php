<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class CiudadanoForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('ciudadano');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idConductor',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nombre',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Nombre',
            ),
        ));
        
        $this->add(array(
            'name' => 'apellido',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Apellido',
            ),
        ));
        
        $this->add(array(
            'name' => 'cedula',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Cedula',
            ),
        ));
        
        $this->add(array(
            'name' => 'direccion',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Direccion',
            ),
        ));
        
        $this->add(array(
            'name' => 'telefono',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Telefono',
            ),
        ));
        $this->add(array(
            'name' => 'registroNro',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'registroNro',
            ),
        ));
         $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-success form-control ',/**para que el boton sea verde*/
            ),
        ));

    }
}
