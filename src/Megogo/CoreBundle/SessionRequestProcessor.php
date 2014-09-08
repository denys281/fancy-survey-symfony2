<?php

namespace Megogo\CoreBundle;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 *
 * Add session id to log
 * Class SessionRequestProcessor
 * @package Megogo\CoreBundle
 * @see http://symfony.com/doc/current/cookbook/logging/monolog.html#adding-a-session-request-token
 *
 */
class SessionRequestProcessor
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @var
     */
    private $token;

    public function __construct( Session $session)
    {
        $this->session = $session;

        // I didn't understand why, but without in session id empty
        if (!$session->isStarted()){
            $session->start();
        }

    }

    public function processRecord(array $record)
    {

        if (null === $this->token) {
            try {
                $this->token = $this->session->getId();
            } catch (\RuntimeException $e) {
                $this->token = '????????';
            }

        }
        $record['extra']['token'] = $this->token;

        return $record;
    }
} 