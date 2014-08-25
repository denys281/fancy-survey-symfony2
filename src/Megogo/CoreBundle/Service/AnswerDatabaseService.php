<?php

namespace Megogo\CoreBundle\Service;
use Doctrine\ORM\EntityManager;


class AnswerDatabaseService {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository('MegogoCoreBundle:Answer');
    }


} 