<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;

/**
 * Transporte.
 *
 * @ORM\Table(name="transporte", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="reg_id", columns={"reg_id"}), @ORM\Index(name="marca_id", columns={"marca_id"}), @ORM\Index(name="modelo_id", columns={"modelo_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Transporte
{
    /**
     * @var int
     *
     * @ORM\Column(name="transp_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $transpId;

    /**
     * @var string
     *
     * @ORM\Column(name="transp_placa", type="string", length=50, nullable=false)
     */
    private $transpPlaca;

    /**
     * @var string
     *
     * @ORM\Column(name="transp_desc", type="string", length=100, nullable=false)
     */
    private $transpDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="chof_cedu", type="string", length=15, nullable=false)
     */
    private $chofCedu;

    /**
     * @var string
     *
     * @ORM\Column(name="chof_nomb", type="string", length=100, nullable=false)
     */
    private $chofNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="chof_apell", type="string", length=100, nullable=false)
     */
    private $chofApell;

    /**
     * @var string
     *
     * @ORM\Column(name="chof_num_lic", type="string", length=50, nullable=false)
     */
    private $chofNumLic;

    /**
     * @var \TranspMarca
     *
     * @ORM\ManyToOne(targetEntity="TranspMarca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marca_id", referencedColumnName="marca_id")
     * })
     */
    private $marca;

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
     * @var \TranspModelo
     *
     * @ORM\ManyToOne(targetEntity="TranspModelo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modelo_id", referencedColumnName="modelo_id")
     * })
     */
    private $modelo;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->chofNomb = Utility::upperCase($this->chofNomb);
        $this->chofApell = Utility::upperCase($this->chofApell);
        $this->chofNumLic = Utility::upperCase($this->chofNumLic);
        $this->transpDesc = Utility::upperCase($this->transpDesc);
        $this->transpPlaca = Utility::upperCase($this->transpPlaca);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->chofNomb = Utility::upperCase($this->chofNomb);
        $this->chofApell = Utility::upperCase($this->chofApell);
        $this->chofNumLic = Utility::upperCase($this->chofNumLic);
        $this->transpDesc = Utility::upperCase($this->transpDesc);
        $this->transpPlaca = Utility::upperCase($this->transpPlaca);
    }

    /**
     * Get transpId.
     *
     * @return int
     */
    public function getTranspId()
    {
        return $this->transpId;
    }

    /**
     * Set transpPlaca.
     *
     * @param string $transpPlaca
     *
     * @return Transporte
     */
    public function setTranspPlaca($transpPlaca)
    {
        $this->transpPlaca = $transpPlaca;

        return $this;
    }

    /**
     * Get transpPlaca.
     *
     * @return string
     */
    public function getTranspPlaca()
    {
        return $this->transpPlaca;
    }

    /**
     * Set transpDesc.
     *
     * @param string $transpDesc
     *
     * @return Transporte
     */
    public function setTranspDesc($transpDesc)
    {
        $this->transpDesc = $transpDesc;

        return $this;
    }

    /**
     * Get transpDesc.
     *
     * @return string
     */
    public function getTranspDesc()
    {
        return $this->transpDesc;
    }

    /**
     * Set chofCedu.
     *
     * @param string $chofCedu
     *
     * @return Transporte
     */
    public function setChofCedu($chofCedu)
    {
        $this->chofCedu = $chofCedu;

        return $this;
    }

    /**
     * Get chofCedu.
     *
     * @return string
     */
    public function getChofCedu()
    {
        return $this->chofCedu;
    }

    /**
     * Set chofNomb.
     *
     * @param string $chofNomb
     *
     * @return Transporte
     */
    public function setChofNomb($chofNomb)
    {
        $this->chofNomb = $chofNomb;

        return $this;
    }

    /**
     * Get chofNomb.
     *
     * @return string
     */
    public function getChofNomb()
    {
        return $this->chofNomb;
    }

    /**
     * Set chofApell.
     *
     * @param string $chofApell
     *
     * @return Transporte
     */
    public function setChofApell($chofApell)
    {
        $this->chofApell = $chofApell;

        return $this;
    }

    /**
     * Get chofApell.
     *
     * @return string
     */
    public function getChofApell()
    {
        return $this->chofApell;
    }

    /**
     * Set chofNumLic.
     *
     * @param string $chofNumLic
     *
     * @return Transporte
     */
    public function setChofNumLic($chofNumLic)
    {
        $this->chofNumLic = $chofNumLic;

        return $this;
    }

    /**
     * Get chofNumLic.
     *
     * @return string
     */
    public function getChofNumLic()
    {
        return $this->chofNumLic;
    }

    /**
     * Set marca.
     *
     * @param \AppBundle\Entity\TranspMarca $marca
     *
     * @return Transporte
     */
    public function setMarca(\AppBundle\Entity\TranspMarca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca.
     *
     * @return \AppBundle\Entity\TranspMarca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set reg.
     *
     * @param \AppBundle\Entity\RegDiario $reg
     *
     * @return Transporte
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
     * Set modelo.
     *
     * @param \AppBundle\Entity\TranspModelo $modelo
     *
     * @return Transporte
     */
    public function setModelo(\AppBundle\Entity\TranspModelo $modelo = null)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo.
     *
     * @return \AppBundle\Entity\TranspModelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }
}
