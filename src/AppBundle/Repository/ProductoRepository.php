<?php

namespace AppBundle\Repository;

class ProductoRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.prodId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getProductos()
    {
        $sql = "SELECT
                p.prod_id AS id, p.prod_nomb AS nomb
                FROM producto p
                INNER JOIN fact_producto f ON(p.prod_id=f.prod_id)
                GROUP BY p.prod_id
                ORDER BY p.prod_nomb
        ";
        $stmt = $this->getEntityManager()
                    ->getConnection()
                    ->prepare($sql);

        //$stmt->bindValue('com_id', 'com_id_aqui');

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
