<?php

namespace AppBundle\Repository;

class TranspModeloRepository extends CustomEntityRepository
{
    public function getNbResults(array $filters)
    {
        $fields = array_keys($this->getClassMetadata()->reflFields);

        $qb = $this->createQueryBuilder('c');
        foreach ($fields as $field) {
            if (isset($filters[$field])) {
                if (!empty($filters[$field])) {
                    $qb->andWhere('c.'.$field.'='.$filters[$field]);
                }
            }
        }

        return $qb->select('count(c.modeloId)')
                ->getQuery()
                ->getSingleScalarResult();
    }
}
