<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;

/**
 * ProdLimite.
 *
 * @ORM\Table(name="prod_limite", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="med_id", columns={"med_id"}), @ORM\Index(name="prod_id", columns={"prod_id"}), @ORM\Index(name="com_id", columns={"com_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProdLimiteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProdLimite
{
    /**
     * @var int
     *
     * @ORM\Column(name="prodl_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prodlId;

    /**
     * @var int
     *
     * @ORM\Column(name="prodl_cant", type="integer", nullable=false)
     */
    private $prodlCant;

    /**
     * @var string
     *
     * @ORM\Column(name="prodl_status", type="string", length=100, nullable=false)
     */
    private $prodlStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="prodl_ruta", type="string", length=100, nullable=false)
     */
    private $prodlRuta;

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
     * @var \Comercio
     *
     * @ORM\ManyToOne(targetEntity="Comercio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="com_id", referencedColumnName="com_id")
     * })
     */
    private $com;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->prodlStatus = Utility::upperCase($this->prodlStatus);
        $this->prodlRuta = Utility::upperCase($this->prodlRuta);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->prodlStatus = Utility::upperCase($this->prodlStatus);
        $this->prodlRuta = Utility::upperCase($this->prodlRuta);
    }

    /**
     * Get prodlId.
     *
     * @return int
     */
    public function getProdlId()
    {
        return $this->prodlId;
    }

    /**
     * Set prodlCant.
     *
     * @param int $prodlCant
     *
     * @return ProdLimite
     */
    public function setProdlCant($prodlCant)
    {
        $this->prodlCant = $prodlCant;

        return $this;
    }

    /**
     * Get prodlCant.
     *
     * @return int
     */
    public function getProdlCant()
    {
        return $this->prodlCant;
    }

    /**
     * Set prodlStatus.
     *
     * @param string $prodlStatus
     *
     * @return ProdLimite
     */
    public function setProdlStatus($prodlStatus)
    {
        $this->prodlStatus = $prodlStatus;

        return $this;
    }

    /**
     * Get prodlStatus.
     *
     * @return string
     */
    public function getProdlStatus()
    {
        return $this->prodlStatus;
    }

    /**
     * Set prodlRuta.
     *
     * @param string $prodlRuta
     *
     * @return ProdLimite
     */
    public function setProdlRuta($prodlRuta)
    {
        $this->prodlRuta = $prodlRuta;

        return $this;
    }

    /**
     * Get prodlRuta.
     *
     * @return string
     */
    public function getProdlRuta()
    {
        return $this->prodlRuta;
    }

    /**
     * Set prod.
     *
     * @param \AppBundle\Entity\Producto $prod
     *
     * @return ProdLimite
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
     * @return ProdLimite
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
     * Set com.
     *
     * @param \AppBundle\Entity\Comercio $com
     *
     * @return ProdLimite
     */
    public function setCom(\AppBundle\Entity\Comercio $com = null)
    {
        $this->com = $com;

        return $this;
    }

    /**
     * Get com.
     *
     * @return \AppBundle\Entity\Comercio
     */
    public function getCom()
    {
        return $this->com;
    }
}
