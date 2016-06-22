<?php

namespace AppBundle\Repository;

class MedidaRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.medId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
