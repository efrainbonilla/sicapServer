<?php

namespace AppBundle\Repository;

class TcomercioRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.tcomId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
