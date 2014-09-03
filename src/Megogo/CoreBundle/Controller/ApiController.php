<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ApiController
 * @package Megogo\CoreBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * Save step one form, if success save step one to db and return step two form. If error validation, return form for step one with validation error
     *
     * @param Request $request
     * @return JsonResponse  status valid|invalid.
     */
    public function saveStepOneAction(Request $request)
    {
        if ($this->get('megogo_core.database')->checkIfUserFinishStepOne($this->get('session')->getId())) {
            return new JsonResponse(['status' => 'exist']);
        }

        $userFormResult = $this->get('megogo_core.form')->handleStepOneForm($request);

        return new JsonResponse($userFormResult);
    }


    public function saveStepTwoAction(Request $request)
    {
        $userFormResult = $this->get('megogo_core.form')->handleStepTwoForm($request);

        return new JsonResponse($userFormResult);
    }

    public function getUserAction()
    {
        return new JsonResponse();
    }

}
