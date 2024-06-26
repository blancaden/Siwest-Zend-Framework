<?php

namespace ZfcUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Base extends ProvidesEventsForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Usuario',
            ),
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control', 
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control', 
            ),
        ));

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Mostrar C�mo',
            ),
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control', 
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password',
                 'class' => 'form-control', 
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => 'Repetir Password',
            ),
            'attributes' => array(
                'type' => 'password',
                 'class' => 'form-control', 
            ),
        ));

        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha()) {
            $this->add(array(
                'name' => 'captcha',
                'type' => 'Zend\Form\Element\Captcha',
                'options' => array(
                    'label' => 'Please type the following text',
                    'captcha' => $this->getRegistrationOptions()->getFormCaptchaOptions(),
                ),
            ));
        }

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Guardar')
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->add(array(
            'name' => 'userId',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        // @TODO: Fix this... getValidator() is a protected method.
        //$csrf = new Element\Csrf('csrf');
        //$csrf->getValidator()->setTimeout($this->getRegistrationOptions()->getUserFormTimeout());
        //$this->add($csrf);
    }
}
