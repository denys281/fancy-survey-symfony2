<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    public function saveStepOneAction(Request $request)
    {
        $userForm = $this->get('megogo_core.form')->handleUserForm($request);

        if ($userForm['status'] === 'valid') {
            $saveData = $this->get('megogo_core.user_database')->saveUserDataFrom($userForm['registration']);
            return new JsonResponse($saveData);
        } else {
            $formView = $this->renderView('MegogoCoreBundle:Core:_registrationForm.html.twig', array('form' => $userForm['form']->createView()));
            return new JsonResponse(['status' => 'error', 'html' => $formView ]);
        }
    }

    public function renderStepTwoAction()
    {
        return new JsonResponse();
    }

    public function saveStepTwoAction()
    {
        return new JsonResponse();
    }

    public function renderStepThreeAction()
    {
        return new JsonResponse();
    }

    public function getUserAction()
    {
        return new JsonResponse();
    }

}
