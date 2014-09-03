<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Megogo\CoreBundle\Form\UserType as UserType;
use Megogo\CoreBundle\Entity\User as User;
use Megogo\CoreBundle\Form\AnswerType as AnswerType;
use Megogo\CoreBundle\Entity\Answer as Answer;
use Megogo\CoreBundle\MegogoCoreEvents;
use Megogo\CoreBundle\Event\MegogoGetResponseCoreEvent;

/**
 * Class CoreController
 * @package Megogo\CoreBundle\Controller
 * @TODO Refactoring events needed
 */
class CoreController extends Controller
{

    /**
     * @Template()
     * @return array
     */
    public function stepOneAction()
    {
        $event = new MegogoGetResponseCoreEvent();
        $this->get('event_dispatcher')->dispatch(MegogoCoreEvents::PRE_STEP_ONE, $event);
        if ($event->getResponse()) {
            return $event->getResponse();
        }

        $stepOneForm = $this->createForm(new UserType(), new User());

        return ['stepOneForm' => $stepOneForm->createView()];
    }


    /**
     * @Template()
     * @return array
     */
    public function stepTwoAction()
    {

        $event = new MegogoGetResponseCoreEvent();
        $this->get('event_dispatcher')->dispatch(MegogoCoreEvents::PRE_STEP_TWO, $event);
        if ($event->getResponse()) {
            return $event->getResponse();
        }

        $userId = $this->get('megogo_core.database')->getUserBy($this->get('session')->getId())->getId();

        $stepTwoForm = $this->createForm(new AnswerType(), new Answer());

        return ['stepTwoForm' => $stepTwoForm->createView(), 'user_id' => $userId];
    }


    /**
     * @Template()
     * @return array
     */
    public function stepThreeAction()
    {
        $event = new MegogoGetResponseCoreEvent();
        $this->get('event_dispatcher')->dispatch(MegogoCoreEvents::PRE_STEP_THREE, $event);
        if ($event->getResponse()) {
            return $event->getResponse();
        }

        $gif = $this->get('megogo_core.html_parser')->getRandomGifFromGifBin();

        return ['gif' => $gif];
    }
}
