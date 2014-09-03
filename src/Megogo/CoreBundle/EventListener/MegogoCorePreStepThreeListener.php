<?php

namespace Megogo\CoreBundle\EventListener;

use Megogo\CoreBundle\Service\DatabaseService;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Session\Session;
use Megogo\CoreBundle\Event\MegogoGetResponseCoreEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *
 * @package Megogo\CoreBundle\EventListener
 */
class MegogoCorePreStepThreeListener
{
    /**
     * @var \Megogo\CoreBundle\Service\DatabaseService
     */
    protected $database;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(DatabaseService $database, Session $session, Router $router)
    {
        $this->database = $database;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     *
     * Check in what step user now and if needed redirect to right step
     * @param MegogoGetResponseCoreEvent $event
     */
    public function onPreStepThree(MegogoGetResponseCoreEvent $event)
    {
        $user = $this->database->getUserBy($this->session->getId());

        if (!$user) {
            $url = $this->router->generate('homepage');
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        } elseif ($user && !$user->getIsFinishSurvey()) {
            $url = $this->router->generate('step_two');
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }

    }
}
