<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Producto.
 *
 * @ORM\Table(name="producto", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="cat_id", columns={"cat_id"}), @ORM\Index(name="grup_id", columns={"grup_id"}), @ORM\Index(name="sgrup_id", columns={"sgrup_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Producto
{
    /**
     * @var int
     *
     * @ORM\Column(name="prod_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prodId;

    /**
     * @var string
     *
     * @ORM\Column(name="prod_nomb", type="string", length=100, nullable=false)
     */
    private $prodNomb;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_id", referencedColumnName="cat_id")
     * })
     */
    private $cat;

    /**
     * @var \Grupo
     *
     * @ORM\ManyToOne(targetEntity="Grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grup_id", referencedColumnName="grup_id")
     * })
     */
    private $grup;

    /**
     * @var \Sgrupo
     *
     * @ORM\ManyToOne(targetEntity="Sgrupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sgrup_id", referencedColumnName="sgrup_id")
     * })
     */
    private $sgrup;

    /**
     * @var \ProdPrestacion
     *
     * @ORM\OneToMany(targetEntity="ProdPrestacion", mappedBy="prod", cascade={"persist", "remove"})
     */
    private $prestc;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->prodNomb = Utility::upperCase($this->prodNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->prodNomb = Utility::upperCase($this->prodNomb);
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->prestc = new ArrayCollection();
    }

    /**
     * Get prodId.
     *
     * @return int
     */
    public function getProdId()
    {
        return $this->prodId;
    }

    /**
     * Set prodNomb.
     *
     * @param string $prodNomb
     *
     * @return Producto
     */
    public function setProdNomb($prodNomb)
    {
        $this->prodNomb = $prodNomb;

        return $this;
    }

    /**
     * Get prodNomb.
     *
     * @return string
     */
    public function getProdNomb()
    {
        return $this->prodNomb;
    }

    /**
     * Set cat.
     *
     * @param \AppBundle\Entity\Categoria $cat
     *
     * @return Producto
     */
    public function setCat(\AppBundle\Entity\Categoria $cat = null)
    {
        $this->cat = $cat;

        return $this;
    }

    /**
     * Get cat.
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCat()
    {
        return $this->cat;
    }

    /**
     * Set grup.
     *
     * @param \AppBundle\Entity\Grupo $grup
     *
     * @return Producto
     */
    public function setGrup(\AppBundle\Entity\Grupo $grup = null)
    {
        $this->grup = $grup;

        return $this;
    }

    /**
     * Get grup.
     *
     * @return \AppBundle\Entity\Grupo
     */
    public function getGrup()
    {
        return $this->grup;
    }

    /**
     * Set sgrup.
     *
     * @param \AppBundle\Entity\Sgrupo $sgrup
     *
     * @return Producto
     */
    public function setSgrup(\AppBundle\Entity\Sgrupo $sgrup = null)
    {
        $this->sgrup = $sgrup;

        return $this;
    }

    /**
     * Get sgrup.
     *
     * @return \AppBundle\Entity\Sgrupo
     */
    public function getSgrup()
    {
        return $this->sgrup;
    }

    /**
     * Add prestc.
     *
     * @param \AppBundle\Entity\ProdPrestacion $prestc
     *
     * @return Producto
     */
    public function addPrestc(\AppBundle\Entity\ProdPrestacion $prestc)
    {
        $this->prestc[] = $prestc;
        $prestc->setProd($this);

        return $this;
    }

    /**
     * Remove prestc.
     *
     * @param \AppBundle\Entity\ProdPrestacion $prestc
     */
    public function removePrestc(\AppBundle\Entity\ProdPrestacion $prestc)
    {
        $this->prestc->removeElement($prestc);
    }

    /**
     * Get prestc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrestc()
    {
        return $this->prestc;
    }
}
