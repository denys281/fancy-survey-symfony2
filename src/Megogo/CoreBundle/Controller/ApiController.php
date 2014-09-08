<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

    /**
     * Save step two form. If success save step two data to db, and get data for step three. If validation error, return form step two with form errors
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveStepTwoAction(Request $request)
    {
        $userFormResult = $this->get('megogo_core.form')->handleStepTwoForm($request);

        return new JsonResponse($userFormResult);
    }

    /**
     * @return Response
     */
    public function getReportAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml');

        $xmlFilePathForWrite = __DIR__ . '/../Resources/views/Api/report.xml.twig';
        $response->setContent(file_get_contents($xmlFilePathForWrite));

        return $response;
    }

    /**
     * @return JsonResponse
     */
    public function clearSessionAction()
    {

        $this->get('session')->invalidate();
        return new JsonResponse('ok');
    }

}
