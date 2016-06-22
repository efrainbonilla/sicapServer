<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RegDiario.
 *
 * @ORM\Table(name="reg_diario", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="com_id", columns={"com_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegDiarioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class RegDiario
{
    /**
     * @var int
     *
     * @ORM\Column(name="reg_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $regId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reg_fech", type="datetime", nullable=false)
     */
    private $regFech;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reg_fech_creado", type="datetime", nullable=false)
     */
    private $regFechCreate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var \Comercio
     *
     * @ORM\ManyToOne(targetEntity="Comercio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="com_id", referencedColumnName="com_id")
     * })
     * @ORM\OrderBy({"com_rif"="DESC"})
     */
    private $com;

    /**
     * @var \Factura
     *
     * @ORM\OneToMany(targetEntity="Factura", mappedBy="reg", cascade={"persist", "remove"})
     */
    private $fact;

    /**
     * @var \Transporte
     *
     * @ORM\OneToMany(targetEntity="Transporte", mappedBy="reg", cascade={"persist", "remove"})
     */
    private $transp;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        /*$this->regFech = new \DateTime();*/
        $this->regFechCreate = new \DateTime();
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fact = new ArrayCollection();
        $this->transp = new ArrayCollection();
    }

    /**
     * Get regId.
     *
     * @return int
     */
    public function getRegId()
    {
        return $this->regId;
    }

    /**
     * Set regFech.
     *
     * @param \DateTime $regFech
     *
     * @return RegDiario
     */
    public function setRegFech(\DateTime $regFech = null)
    {
        $this->regFech = $regFech;

        return $this;
    }

    /**
     * Get regFech.
     *
     * @return \DateTime
     */
    public function getRegFech()
    {
        return $this->regFech;
    }

    /**
     * Set regFech.
     *
     * @param \DateTime $regFech
     *
     * @return RegDiario
     */
    public function setRegFechCreate($regFechCreate)
    {
        $this->regFechCreate = $regFechCreate;

        return $this;
    }

    /**
     * Get regFech.
     *
     * @return \DateTime
     */
    public function getRegFechCreate()
    {
        return $this->regFechCreate;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RegDiario
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set com.
     *
     * @param \AppBundle\Entity\Comercio $com
     *
     * @return RegDiario
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

    /**
     * Add fact.
     *
     * @param \AppBundle\Entity\Factura $fact
     *
     * @return RegDiario
     */
    public function addFact(\AppBundle\Entity\Factura $fact)
    {
        $this->fact[] = $fact;
        $fact->setReg($this);

        return $this;
    }

    /**
     * Remove fact.
     *
     * @param \AppBundle\Entity\Factura $fact
     */
    public function removeFact(\AppBundle\Entity\Factura $fact)
    {
        $this->fact->removeElement($fact);
    }

    /**
     * Get fact.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFact()
    {
        return $this->fact;
    }

    /**
     * Add transp.
     *
     * @param \AppBundle\Entity\Transporte $transp
     *
     * @return RegDiario
     */
    public function addTransp(\AppBundle\Entity\Transporte $transp)
    {
        $this->transp[] = $transp;
        $transp->setReg($this);

        return $this;
    }

    /**
     * Remove transp.
     *
     * @param \AppBundle\Entity\Transporte $transp
     */
    public function removeTransp(\AppBundle\Entity\Transporte $transp)
    {
        $this->transp->removeElement($transp);
    }

    /**
     * Get transp.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransp()
    {
        return $this->transp;
    }
}
