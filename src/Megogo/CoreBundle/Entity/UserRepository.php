<?php

namespace Megogo\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    public function getUserForXml()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('user', 'answer')
            ->from('MegogoCoreBundle:User', 'user')
            ->addOrderBy('user.createdAt', 'DESC')
            ->andWhere('user.isOnReport=:on_report')
            ->leftJoin('user.answer', 'answer')
            ->setParameter(':on_report', false);

        return $qb->getQuery()->getResult();
    }
}
