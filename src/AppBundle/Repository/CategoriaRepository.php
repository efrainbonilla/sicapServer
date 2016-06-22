<?php

namespace AppBundle\Repository;

class CategoriaRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.catId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
