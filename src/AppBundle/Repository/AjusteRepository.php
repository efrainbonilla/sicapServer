<?php

namespace AppBundle\Repository;

class AjusteRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.id)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getAjustes()
    {
        $sql = "select * from ajuste";
        $stmt = $this->getEntityManager()
                    ->getConnection()
                    ->prepare($sql);

        $stmt->execute();
        $rows = $stmt->fetchAll();

        $columnVal = array();

        foreach ($rows as $key => $value) {
            $columnVal[$value['clave']] = $value['valor'];
        }

        return $columnVal;
    }
}
