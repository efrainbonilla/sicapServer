<?php

namespace AppBundle\Repository;

class SgrupoRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.sgrupId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
