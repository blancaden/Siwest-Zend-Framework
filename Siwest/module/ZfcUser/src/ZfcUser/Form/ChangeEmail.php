<?php

namespace ZfcUser\Form;

use ZfcBase\Form\ProvidesEventsForm;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUser\Options\AuthenticationOptionsInterface;

class ChangeEmail extends ProvidesEventsForm
{
    public function __construct($name = null, AuthenticationOptionsInterface $options)
    {
        $this->setAuthenticationOptions($options);
        parent::__construct($name);

        $this->add(array(
            'name' => 'identity',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'newIdentity',
            'options' => array(
                'label' => 'Nuevo Email',
            ),
            'attributes' => array(
                'type' => 'text',
                'class'=>'form-control'
            ),
        ));

        $this->add(array(
            'name' => 'newIdentityVerify',
            'options' => array(
                'label' => 'Verificar Nuevo Email',
            ),
            'attributes' => array(
                'type' => 'text',
                'class'=>'form-control'
            ),
        ));

        $this->add(array(
            'name' => 'credential',
            'options' => array(
                'label' => 'Contraseña',
            ),
            'attributes' => array(
                'type' => 'password',
                'class'=>'form-control'
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    /**
     * Set Authentication-related Options
     *
     * @param AuthenticationOptionsInterface $authOptions
     * @return Login
     */
    public function setAuthenticationOptions(AuthenticationOptionsInterface $authOptions)
    {
        $this->authOptions = $authOptions;
        return $this;
    }

    /**
     * Get Authentication-related Options
     *
     * @return AuthenticationOptionsInterface
     */
    public function getAuthenticationOptions()
    {
        return $this->authOptions;
    }
}
