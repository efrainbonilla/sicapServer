<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Factura.
 *
 * @ORM\Table(name="factura", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="reg_id", columns={"reg_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Factura
{
    /**
     * @var int
     *
     * @ORM\Column(name="fact_Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $factId;

    /**
     * @var string
     *
     * @ORM\Column(name="fact_codi", type="string", length=50, nullable=false)
     */
    private $factCodi;

    /**
     * @var float
     *
     * @ORM\Column(name="fact_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $factTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="fact_obs", type="text", nullable=false)
     */
    private $factObs;

    /**
     * @var \RegDiario
     *
     * @ORM\ManyToOne(targetEntity="RegDiario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reg_id", referencedColumnName="reg_id")
     * })
     */
    private $reg;

    /**
     * @var \FactProducto
     *
     * @ORM\OneToMany(targetEntity="FactProducto", mappedBy="fact", cascade={"persist", "remove"})
     */
    private $factProd;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->factCodi = Utility::upperCase($this->factCodi);
        $this->factObs = Utility::upperCase($this->factObs);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->factCodi = Utility::upperCase($this->factCodi);
        $this->factObs = Utility::upperCase($this->factObs);
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->factProd = new ArrayCollection();
    }

    /**
     * Get factId.
     *
     * @return int
     */
    public function getFactId()
    {
        return $this->factId;
    }

    /**
     * Set factCodi.
     *
     * @param string $factCodi
     *
     * @return Factura
     */
    public function setFactCodi($factCodi)
    {
        $this->factCodi = $factCodi;

        return $this;
    }

    /**
     * Get factCodi.
     *
     * @return string
     */
    public function getFactCodi()
    {
        return $this->factCodi;
    }

    /**
     * Set factTotal.
     *
     * @param float $factTotal
     *
     * @return Factura
     */
    public function setFactTotal($factTotal)
    {
        $this->factTotal = $factTotal;

        return $this;
    }

    /**
     * Get factTotal.
     *
     * @return float
     */
    public function getFactTotal()
    {
        return $this->factTotal;
    }

    /**
     * Set factObs.
     *
     * @param string $factObs
     *
     * @return Factura
     */
    public function setFactObs($factObs)
    {
        $this->factObs = $factObs;

        return $this;
    }

    /**
     * Get factObs.
     *
     * @return string
     */
    public function getFactObs()
    {
        return $this->factObs;
    }

    /**
     * Set reg.
     *
     * @param \AppBundle\Entity\RegDiario $reg
     *
     * @return Factura
     */
    public function setReg(\AppBundle\Entity\RegDiario $reg = null)
    {
        $this->reg = $reg;

        return $this;
    }

    /**
     * Get reg.
     *
     * @return \AppBundle\Entity\RegDiario
     */
    public function getReg()
    {
        return $this->reg;
    }

    /**
     * Add factProd.
     *
     * @param \AppBundle\Entity\FactProducto $factProd
     *
     * @return Factura
     */
    public function addFactProd(\AppBundle\Entity\FactProducto $factProd)
    {
        $this->factProd[] = $factProd;
        $factProd->setFact($this);

        return $this;
    }

    /**
     * Remove factProd.
     *
     * @param \AppBundle\Entity\FactProducto $factProd
     */
    public function removeFactProd(\AppBundle\Entity\FactProducto $factProd)
    {
        $this->factProd->removeElement($factProd);
    }

    /**
     * Get factProd.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactProd()
    {
        return $this->factProd;
    }
}
