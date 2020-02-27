<?php

namespace UserBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getuserdatabyUsername($user_name)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.username LIKE :username')
            ->setParameter('username', $user_name);
        return $qb->getQuery()->getResult();

    }

}