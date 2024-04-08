<?php
namespace Contravencion\Form;

use Zend\Form\Form;

class MunicipioForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('municipio');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idMunicipio',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'municipio',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control '
            ),
            'options' => array(
                'label' => 'Municipio',
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
