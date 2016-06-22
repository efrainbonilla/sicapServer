<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactProducto.
 *
 * @ORM\Table(name="fact_producto", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="prod_id", columns={"prod_id"}), @ORM\Index(name="prestc_med", columns={"med_id"}), @ORM\Index(name="med_id", columns={"med_id"}), @ORM\Index(name="fact_id", columns={"fact_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class FactProducto
{
    /**
     * @var int
     *
     * @ORM\Column(name="fprod_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $fprodId;

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
     * @var float
     *
     * @ORM\Column(name="prestc_num", type="float", precision=10, scale=0, nullable=false)
     */
    private $prestcNum;

    /**
     * @var \Medida
     *
     * @ORM\ManyToOne(targetEntity="Medida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prestc_med", referencedColumnName="med_id")
     * })
     */
    private $prestcMed;

    /**
     * @var int
     *
     * @ORM\Column(name="fprod_cant", type="integer", nullable=false)
     */
    private $fprodCant;

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
     * @var \Factura
     *
     * @ORM\ManyToOne(targetEntity="Factura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fact_id", referencedColumnName="fact_Id")
     * })
     */
    private $fact;

    /**
     * Get fprodId.
     *
     * @return int
     */
    public function getFprodId()
    {
        return $this->fprodId;
    }

    /**
     * Set prestcNum.
     *
     * @param float $prestcNum
     *
     * @return FactProducto
     */
    public function setPrestcNum($prestcNum)
    {
        $this->prestcNum = $prestcNum;

        return $this;
    }

    /**
     * Get prestcNum.
     *
     * @return float
     */
    public function getPrestcNum()
    {
        return $this->prestcNum;
    }

    /**
     * Set fprodCant.
     *
     * @param int $fprodCant
     *
     * @return FactProducto
     */
    public function setFprodCant($fprodCant)
    {
        $this->fprodCant = $fprodCant;

        return $this;
    }

    /**
     * Get fprodCant.
     *
     * @return int
     */
    public function getFprodCant()
    {
        return $this->fprodCant;
    }

    /**
     * Set prod.
     *
     * @param \AppBundle\Entity\Producto $prod
     *
     * @return FactProducto
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
     * Set prestcMed.
     *
     * @param \AppBundle\Entity\Medida $prestcMed
     *
     * @return FactProducto
     */
    public function setPrestcMed(\AppBundle\Entity\Medida $prestcMed = null)
    {
        $this->prestcMed = $prestcMed;

        return $this;
    }

    /**
     * Get prestcMed.
     *
     * @return \AppBundle\Entity\Medida
     */
    public function getPrestcMed()
    {
        return $this->prestcMed;
    }

    /**
     * Set med.
     *
     * @param \AppBundle\Entity\Medida $med
     *
     * @return FactProducto
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

    /**
     * Set fact.
     *
     * @param \AppBundle\Entity\Factura $fact
     *
     * @return FactProducto
     */
    public function setFact(\AppBundle\Entity\Factura $fact = null)
    {
        $this->fact = $fact;

        return $this;
    }

    /**
     * Get fact.
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFact()
    {
        return $this->fact;
    }
}
