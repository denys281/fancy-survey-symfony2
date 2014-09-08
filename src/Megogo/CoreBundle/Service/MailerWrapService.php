<?php

namespace Megogo\CoreBundle\Service;

use \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use \Swift_Mailer;

/**
 * Send email
 *
 * @package Megogo\CoreBundle\Service
 */
class MailerWrapService
{

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * Constructor
     *
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param string $fromEmail
     */
    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, $fromEmail)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromEmail = $fromEmail;

    }

    /**
     * Send email after xml report created
     *
     * @param $to
     * @param $date
     * @return bool
     * @throws \Exception
     */
    public function sendEmailAfterXmlReportCreated($to, $date)
    {
        // Body
        $body = $this->templating->render(
            'MegogoCoreBundle:Mailer:xmlReportCreated.html.twig',
            ['email' => $to, 'date' => $date]
        );

        $send = $this->sendMailWith('Fancy Survey command report', $to, $body);

        if (!is_string($send)) {
            return true;
        } else {
            throw new \Exception($send);
        }
    }



    /**
     * Send mail
     *
     * @param string $subject
     * @param string $to
     * @param string $body
     * @return bool|string
     */
    public function sendMailWith($subject, $to, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$this->fromEmail => $this->fromEmail])
            ->setTo($to)
            ->setBody($body, 'text/html');
        try {
            $this->mailer->send($message);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }


    /**
     * Format email adress from string to mailer format
     *
     * @param string $email
     * @return array
     */
    public function format($email)
    {
        $email = preg_replace('/\s/', '', $email);
        $toEmail = explode(",", $email);

        return $toEmail;
    }
}
