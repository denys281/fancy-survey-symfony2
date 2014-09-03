<?php

namespace Megogo\CoreBundle\Service;

use Megogo\CoreBundle\Service\DatabaseService;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Megogo\CoreBundle\Form\UserType;
use Megogo\CoreBundle\Entity\User;
use Megogo\CoreBundle\Form\AnswerType as AnswerType;
use Megogo\CoreBundle\Entity\Answer as Answer;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Megogo\CoreBundle\Service\HtmlParserService;
use Monolog\Logger;

/**
 * Handle forms
 * @package Megogo\CoreBundle\Service
 */
class FormService
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var DatabaseService
     */
    protected $database;


    /**
     * @var HtmlParserService
     */
    protected $htmlParser;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templating;

    /**
     * @param FormFactory $formFactory
     * @param DatabaseService $database
     * @param EngineInterface $templating
     * @param HtmlParserService $htmlParser
     * @param Logger $logger
     */
    public function __construct(
        FormFactory $formFactory,
        DatabaseService $database,
        EngineInterface $templating,
        HtmlParserService $htmlParser,
        Logger $logger
    ) {
        $this->form = $formFactory;
        $this->database = $database;
        $this->templating = $templating;
        $this->htmlParser = $htmlParser;
        $this->logger = $logger;
    }

    /**
     * Check if form valid. Save data to database. Return html for step two form
     * @param  Request $request Request object
     * @return array
     */
    public function handleStepOneForm(Request $request)
    {
        $form = $this->form->create(new UserType(), new User());
        $form->handleRequest($request);


        if ($form->isValid()) {

            //Save user data to db
            $saveData = $this->database->saveDataFrom($form->getData());

            if ($saveData['status'] == 'error') {
                $this->logger->error($saveData['msg']);

                return ['status' => 'db_error'];
            }

            //Render step two form html
            $stepTwoFormView = $this->renderStepTwoFormViewWith($saveData);

            return ['status' => 'valid', 'saveData' => $saveData, 'stepTwoFormView' => $stepTwoFormView];
        } else {

            //Log errors
            $this->logFormError($this->getErrorMessages($form), 'step one');

            //Render step one form with errors
            $stepOneFormView = $this->renderStepOneFormViewWith($form);

            return ['status' => 'invalid', 'stepOneFormView' => $stepOneFormView];
        }

    }

    /**
     *
     * Render step two form html view
     * @param array $saveData
     * @return mixed The rendered form html view
     */
    private function renderStepTwoFormViewWith($saveData)
    {
        $stepTwoForm = $this->form->create(new AnswerType(), new Answer());
        $stepTwoFormView = $this->templating->render(
            'MegogoCoreBundle:Core:_stepTwoForm.html.twig',
            ['form' => $stepTwoForm->createView(), 'user_id' => $saveData['user_id']]
        );

        return $stepTwoFormView;
    }


    /**
     * @param object $form
     * @param mixed $userId
     * @return string
     */
    private function renderStepTwoFormViewWithFormAndUserId($form, $userId)
    {
        $formView = $this->templating->render(
            'MegogoCoreBundle:Core:_stepTwoForm.html.twig',
            ['form' => $form->createView(), 'user_id' => $userId]
        );

        return $formView;
    }

    /**
     *
     * Render step one form html view
     * @param object $form formObject
     * @return mixed The rendered form html view
     */
    private function renderStepOneFormViewWith($form)
    {
        $formView = $this->templating->render(
            'MegogoCoreBundle:Core:_stepOneForm.html.twig',
            ['form' => $form->createView()]
        );

        return $formView;
    }


    /**
     * Check if form valid. Save data to database. Return html for step three
     * @param  Request $request Request object
     * @return array
     */
    public function handleStepTwoForm(Request $request)
    {
        $form = $this->form->create(new AnswerType(), new Answer());
        $form->handleRequest($request);

        if ($form->isValid()) {

            //Save user data to db
            $saveData = $this->database->saveStepTwoDataFrom($form->getData());

            if ($saveData['status'] == 'error') {
                $this->logger->error($saveData['msg']);

                return ['status' => 'db_error'];
            }

            //Render step three
            $gif = $this->htmlParser->getRandomGifFromGifBin();
            $stepThreeView = $this->templating->render(
                'MegogoCoreBundle:Core:_stepThree.html.twig',
                ['gif' => $gif]
            );

            return ['status' => 'valid', 'stepThreeView' => $stepThreeView];
        } else {

            //Log errors
            $this->logFormError($this->getErrorMessages($form), 'step two');

            //Render step one form with errors
            $stepTwpFormView = $this->renderStepTwoFormViewWithFormAndUserId(
                $form,
                $form->getData()->getUser()->getId()
            );

            return ['status' => 'invalid', 'stepTwoFormView' => $stepTwpFormView];
        }

    }

    /**
     *
     * Get form errors
     * @see https://gist.github.com/WishCow/5101428
     * @param object $form
     * @return array
     */
    private function getErrorMessages($form)
    {
        $errors = array();

        if (count($form) > 0) {
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        } else {
            foreach ($form->getErrors() as $key => $error) {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Log form errors
     * @param null|array $messages
     * @param string $step
     */
    private function logFormError($messages, $step)
    {
        if (count($messages) > 0) {
            foreach ($messages as $message) {
                $this->logger->error('Form error ' . $step . ': ' . $message[0]);
            }
        }
    }

} 