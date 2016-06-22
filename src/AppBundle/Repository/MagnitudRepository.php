<?php

namespace AppBundle\Repository;

class MagnitudRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.magId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
