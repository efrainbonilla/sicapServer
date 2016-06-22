<?php

namespace AppBundle\Repository;

class TranspMarcaRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.marcaId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
