<?php

namespace Megogo\CoreBundle\Service;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Megogo\CoreBundle\Form\UserType;
use Megogo\CoreBundle\Entity\User;

class FormService {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(FormFactory $formFactory, Session $session)
    {
        $this->form = $formFactory;
        $this->session = $session;
    }

    public function handleUserForm($request)
    {
        $form = $this->form->create(new UserType(), new User());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            return ['status' => 'valid', 'registration' => $registration];
        } else{
            return ['status' => 'invalid', 'form' => $form];
        }
    }

} 