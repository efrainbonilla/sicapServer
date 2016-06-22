<?php

namespace AppBundle\Repository;

class RegDiarioRepository extends CustomEntityRepository
{
    public function getNbResults()
    {
        return $this->createQueryBuilder('p')
                    ->select('count(p.regId)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getByDateBetween(\Datetime $dateFrom, \Datetime $dateTo, array $data = array())
    {
        $from = new \DateTime($dateFrom->format('Y-m-d').' 00:00:00');
        $to = new \DateTime($dateTo->format('Y-m-d').' 23:59:59');

        $sql = "SELECT
		cat.cat_nomb AS grup1,
		grup.grup_nomb AS grup2,
		sgrup.sgrup_nomb AS grup3,
		prod.prod_nomb AS producto,
		prestacion.prestc AS prestacion,
		SUM(factprod.fprod_cant) AS total,
		cantidad.dnm_nomb AS denominacion
		FROM reg_diario regd
		INNER JOIN factura fact ON(regd.reg_id=fact.reg_id)
		INNER JOIN fact_producto factprod ON(fact.fact_id=factprod.fact_id)
		INNER JOIN producto prod ON(factprod.prod_id=prod.prod_id)
		INNER JOIN categoria cat ON(prod.cat_id=cat.cat_id)
		INNER JOIN grupo grup ON(prod.grup_id=grup.grup_id)
		INNER JOIN sgrupo sgrup ON(prod.sgrup_id=sgrup.sgrup_id)
		INNER JOIN (
			SELECT
			factprod.fprod_id,
			CONCAT(factprod.prestc_num,' ', med.med_nomb) AS prestc,
			CONCAT(factprod.prestc_num,' ', med.med_nomb, ' ', prod.prod_nomb) AS prestc_group
			FROM fact_producto factprod
			INNER JOIN producto prod ON(prod.prod_id=factprod.prod_id)
			INNER JOIN medida med ON(med.med_id=factprod.prestc_med)
		) AS prestacion ON(factprod.fprod_id=prestacion.fprod_id)
		INNER JOIN (
			SELECT
			factprod.fprod_id,
			CONCAT(factprod.fprod_cant,' ', med.med_nomb) AS dnm,
			med.med_nomb AS dnm_nomb
			FROM fact_producto factprod
			INNER JOIN medida med ON(med.med_id=factprod.med_id)
		) AS cantidad ON(factprod.fprod_id=cantidad.fprod_id)
		WHERE ";

        if (in_array('comId', array_keys($data))) {
            $sql .= 'regd.com_id = :com_id AND ';
        }

        if (in_array('prodId', array_keys($data))) {
            $sql .= 'prod.prod_id = :prod_id AND ';
        }

        if (in_array('group1', array_keys($data))) {
            $sql .= 'cat.cat_id = :cat_id AND ';
        }

        if (in_array('group2', array_keys($data))) {
            $sql .= 'grup.grup_id = :grup_id AND ';
        }

        if (in_array('group3', array_keys($data))) {
            $sql .= 'sgrup.sgrup_id = :sgrup_id AND ';
        }

        $sql .= 'regd.reg_fech BETWEEN :date_from AND :date_to
		GROUP BY prestacion.prestc_group';

        $stmt = $this->getEntityManager()
                    ->getConnection()
                    ->prepare($sql);

        if (in_array('comId', array_keys($data))) {
            $stmt->bindValue('com_id', $data['comId']);
        }

        if (in_array('prodId', array_keys($data))) {
            $stmt->bindValue('prod_id', $data['prodId']);
        }

        if (in_array('group1', array_keys($data))) {
            $stmt->bindValue('cat_id', $data['group1']);
        }

        if (in_array('group2', array_keys($data))) {
            $stmt->bindValue('grup_id', $data['group2']);
        }

        if (in_array('group3', array_keys($data))) {
            $stmt->bindValue('sgrup_id', $data['group3']);
        }

        $stmt->bindValue('date_from', $from->format('Y-m-d H:i:s'));
        $stmt->bindValue('date_to', $to->format('Y-m-d H:i:s'));
        $stmt->execute();

        return array(
            'dateFrom' => $from->format('Y-m-d H:i:s'),
            'dateTo' => $to->format('Y-m-d H:i:s'),
            'betweenData' => $stmt->fetchAll(),
        );

        /*$qb = $this->createQueryBuilder('r');
        $qb
            ->where('r.com = :id')
            ->andWhere($qb->expr()->between(
                'r.regFech',
                ':from',
                ':to'
            ))
            ->setParameter('id', $comId)
            ->setParameter('from', $from)
            ->setParameter('to', $to)
        ;

        return $qb->getQuery()->getResult();*/
    }

    public function getComerciantes()
    {
        $sql = "SELECT
                c.com_id AS id, CONCAT(c.com_rif, ' ', c.com_nomb_estb) AS rif_razon_social
                FROM reg_diario reg
                INNER JOIN comercio c ON(reg.com_id=c.com_id)
                GROUP BY reg.com_id
        ";
        $stmt = $this->getEntityManager()
                    ->getConnection()
                    ->prepare($sql);

        //$stmt->bindValue('com_id', 'com_id_aqui');

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
