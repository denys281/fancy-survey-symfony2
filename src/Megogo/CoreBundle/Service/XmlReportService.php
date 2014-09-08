<?php

namespace Megogo\CoreBundle\Service;

use Megogo\CoreBundle\Service\DatabaseService;
use Symfony\Component\Form\FormFactory;
use Megogo\CoreBundle\Entity\User;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


/**
 * Work with xml, create report, etc
 * @package Megogo\CoreBundle\Service
 */
class XmlReportService
{

    /**
     * @var DatabaseService
     */
    protected $database;


    /**
     * @param DatabaseService $database
     */
    public function __construct(DatabaseService $database)
    {
        $this->database = $database;
    }

    /**
     * Create log in xml format
     */
    public function createLog()
    {
        $xmlFilePathForWrite = __DIR__ . '/../Resources/views/Api/report.xml.twig';

        $this->checkFileExist($xmlFilePathForWrite);
        $user = $this->database->getUserForXmlReport();
        $this->writeToFile($user, $xmlFilePathForWrite);

    }

    /**
     * @param string $filePath
     */
    private function checkFileExist($filePath)
    {
        $fs = new Filesystem();

        $fileExist = $fs->exists($filePath);

        // Create new file if file doesn't exist
        if (!$fileExist) {
            $xml = simplexml_load_string("<data><users><user></user></users></data>");
            $xml->asXml($filePath);
        }
    }

    /**
     *
     * Write user data to xml report
     * @param object $data
     * @param  $xmlFilePathForWrite
     */
    private function writeToFile($data, $xmlFilePathForWrite)
    {
        $xmlFileToWrite = simplexml_load_file($xmlFilePathForWrite);

        foreach ($data as $element) {
            $log = $this->getLogInXmlForCurrentUser($element->getUserSessionId());

            $users = $xmlFileToWrite->users;

            $user = $users->addChild('user');
            $user->addChild('id', $element->getId());
            $user->addChild('first_name', $element->getFirstName());
            $user->addChild('last_name', $element->getLastName());
            $user->addChild('email', $element->getEmail());
            $user->addChild('birthday', $element->getBirthday()->format('d-m-Y'));
            $user->addChild('shoe_size', $element->getShoeSize());
            $user->addChild('user_session_id', $element->getUserSessionId());
            $user->addChild('ip', $element->getIp());
            $user->addChild('is_finish_survey', $element->getIsFinishSurvey());

            if (count($element->getAnswer())) {
                $answer = $user->addChild('answer');
                foreach ($element->getAnswer() as $answerElement) {
                    $answer->addChild('ice_cream', $answerElement->getIceCream());
                    $answer->addChild('superhero', $answerElement->getSuperhero());
                    $answer->addChild('movie_star', $answerElement->getMovieStar());
                    $answer->addChild('world_end', $answerElement->getWorldEnd()->format('d-m-Y'));
                    $answer->addChild('super_bowl', $answerElement->getSuperBowl());
                }
            }

            if (count($log) > 0) {
                $logs = $user->addChild('logs');
                foreach ($log as $key => $value) {
                    $logs->addChild('log_' . $key, $value);
                }
            }

            $this->database->checkUserInReport($element->getId());

        }

        $xmlFileToWrite->asXML($xmlFilePathForWrite);
    }

    /**
     * @param string $sessionId
     * @return mixed
     */
    private function getLogInXmlForCurrentUser($sessionId)
    {
        exec('grep ' . $sessionId . ' ' . __DIR__ . '/../../../../app/logs/user.log', $result);

        return $result;
    }


} 