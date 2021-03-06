<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * UserRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function findByAdapter()
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $adapter = new DoctrineORMAdapter($queryBuilder);

        return $adapter;
    }
}
