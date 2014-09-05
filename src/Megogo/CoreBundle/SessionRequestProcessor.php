<?php
/**
 * Created by PhpStorm.
 * User: denyskurets
 * Date: 03.09.14
 * Time: 23:32
 */

namespace Megogo\CoreBundle;

use Symfony\Component\HttpFoundation\Session\Session;

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

//        // I didn't understand why, but without in session id empty
//        if (!$session->isStarted()){
//            $session->start();
//        }

//        var_dump( $this->session->getId());
//        die();

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