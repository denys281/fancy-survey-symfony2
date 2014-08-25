<?php

namespace Megogo\CoreBundle\Service;

use Doctrine\ORM\EntityManager;


class UserDatabaseService
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository('MegogoCoreBundle:User');
    }

    public function saveUserDataFrom($form)
    {
        $this->em->persist($form);

        try {
          $this->em->flush();
        }
        catch(\Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }

        return ['status' => 'success', 'msg' => 'User saved'];
    }



} 