<?php

namespace AppBundle\Repository;

class ProdPrestacionRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.prestcId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
