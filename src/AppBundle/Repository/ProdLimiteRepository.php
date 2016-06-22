<?php

namespace AppBundle\Repository;

class ProdLimiteRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.prodlId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
