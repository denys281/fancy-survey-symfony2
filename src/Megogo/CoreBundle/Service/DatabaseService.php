<?php

namespace Megogo\CoreBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class DatabaseService, work with repository, etc.
 * @package Megogo\CoreBundle\Service
 */
class DatabaseService
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->userRepository = $entityManager->getRepository('MegogoCoreBundle:User');
    }

    /**
     * @param $form
     * @return array
     */
    public function saveDataFrom($form)
    {
        $this->em->persist($form);

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }

        return ['status' => 'success', 'msg' => 'Saved', 'user_id' => $form->getId()];
    }


    public function saveStepTwoDataFrom($form)
    {
        $this->em->getConnection()->beginTransaction();
        try {
            $this->em->persist($form);
            $user = $form->getUser();
            $user->setIsFinishSurvey(true);
            $this->em->persist($user);
            $this->em->flush();
            $this->em->getConnection()->commit();
            return ['status' => 'success', 'msg' => 'Saved'];
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    /**
     * @param string $userSessionId
     * @return bool
     */
    public function  checkIfUserFinishStepOne($userSessionId)
    {
        if ($this->userRepository->findOneByUserSessionId($userSessionId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $userSessionId
     * @return object
     */
    public function  getUserBy($userSessionId)
    {
        return $this->userRepository->findOneByUserSessionId($userSessionId);

    }

}