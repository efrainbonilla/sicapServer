<?php

namespace AppBundle\Repository;

class GrupoRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.grupId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
