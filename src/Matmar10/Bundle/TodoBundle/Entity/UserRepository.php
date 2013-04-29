<?php

namespace Matmar10\Bundle\TodoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository
{

    public function findOneByTwitterScreenName($twitterScreenName)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.twitterScreenName = :twitterScreenName')
            ->setParameter('twitterScreenName', $twitterScreenName)
            ->getQuery()
        ;

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $user;
    }

    public function findOneByTwitterAuthInternalToken($internalToken)
    {
        /*
        $query = $this->createQueryBuilder('u, Matmar10TodoBundle:TwitterAuth ta')
            ->select('u, ta')
            ->leftJoin('u.twitter_auth_id', 'ta', 'WITH', 'u.twitter_auth_id = ta.id')
            ->getQuery();
        */

        $query = $this->getEntityManager()
            ->createquery('
                SELECT u, t FROM Matmar10TodoBundle:User u
                JOIN u.twitterAuth t
                WHERE t.internalToken = :internalToken
            ')->setParameter('internalToken', $internalToken);

        try {
            $user = $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $user;
    }


}