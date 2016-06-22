<?php

namespace AppBundle\Repository;

class ComercioRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.comId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getLcomercios()
    {
        $sql = 'SELECT
                    c.*,
                    CONCAT(c.com_nomb_estb, " (", c.com_rif, ")") AS com_estb_rif,
                    CONCAT(c.com_prop_nomb, " ", c.com_prop_apell) AS com_prop
                    FROM comercio c
        ';
        $stmt = $this->getEntityManager()
                    ->getConnection()
                    ->prepare($sql);

        //$stmt->bindValue('com_id', 'com_id_aqui');

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
