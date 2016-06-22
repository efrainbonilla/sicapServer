<?php

namespace AppBundle\Repository;

class ComRepresRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.represId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
