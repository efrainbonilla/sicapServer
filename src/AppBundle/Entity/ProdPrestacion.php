<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProdPrestacion.
 *
 * @ORM\Table(name="prod_prestacion", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="prod_id", columns={"prod_id"}), @ORM\Index(name="med_id", columns={"med_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProdPrestacionRepository")
 */
class ProdPrestacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="prestc_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prestcId;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prod_id", referencedColumnName="prod_id")
     * })
     */
    private $prod;

    /**
     * @var \Medida
     *
     * @ORM\ManyToOne(targetEntity="Medida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="med_id", referencedColumnName="med_id")
     * })
     */
    private $med;

    /**
     * Get prestcId.
     *
     * @return int
     */
    public function getPrestcId()
    {
        return $this->prestcId;
    }

    /**
     * Set prod.
     *
     * @param \AppBundle\Entity\Producto $prod
     *
     * @return ProdPrestacion
     */
    public function setProd(\AppBundle\Entity\Producto $prod = null)
    {
        $this->prod = $prod;

        return $this;
    }

    /**
     * Get prod.
     *
     * @return \AppBundle\Entity\Producto
     */
    public function getProd()
    {
        return $this->prod;
    }

    /**
     * Set med.
     *
     * @param \AppBundle\Entity\Medida $med
     *
     * @return ProdPrestacion
     */
    public function setMed(\AppBundle\Entity\Medida $med = null)
    {
        $this->med = $med;

        return $this;
    }

    /**
     * Get med.
     *
     * @return \AppBundle\Entity\Medida
     */
    public function getMed()
    {
        return $this->med;
    }
}
