<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

/**
 * Comercio.
 *
 * @ORM\Table(name="comercio", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComercioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comercio
{
    /**
     * @var int
     *
     * @ORM\Column(name="com_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $comId;

    /**
     * @var string
     *
     * @ORM\Column(name="com_rif", type="string", length=15, nullable=false)
     */
    private $comRif;

    /**
     * @var string
     * @ORM\Column(name="com_nomb_estb", type="string", length=100, nullable=false)
     */
    private $comNombEstb;

    /**
     * @var string
     *
     * @ORM\Column(name="com_num_ptte", type="string", length=20, nullable=false)
     */
    private $comNumPtte;

    /**
     * @var \Date
     *
     * @Type("DateTime<'Y-m-d'>")
     * @ORM\Column(name="com_fechptte_ini", type="date", nullable=true)
     */
    private $comFechptteIni;

    /**
     * @var \Date
     *
     * @Type("DateTime<'Y-m-d'>")
     * @ORM\Column(name="com_fechptte_fin", type="date", nullable=true)
     */
    private $comFechptteFin;

    /**
     * @var float
     *
     * @ORM\Column(name="com_capit", type="float", precision=10, scale=0, nullable=false)
     */
    private $comCapit;

    /**
     * @var string
     *
     * @ORM\Column(name="com_num_lic", type="string", length=20, nullable=true)
     */
    private $comNumLic;

    /**
     * @var string
     *
     * @ORM\Column(name="com_telef_fijo", type="string", length=11, nullable=false)
     */
    private $comTelefFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="com_act_ecnma", type="string", length=100, nullable=false)
     */
    private $comActEcnma;

    /**
     * @var string
     *
     * @ORM\Column(name="com_prop_nac", type="string", length=1, nullable=false)
     */
    private $comPropNac;

    /**
     * @var string
     *
     * @ORM\Column(name="com_prop_cedu", type="string", length=15, nullable=false)
     */
    private $comPropCedu;

    /**
     * @var string
     *
     * @ORM\Column(name="com_prop_nomb", type="string", length=100, nullable=false)
     */
    private $comPropNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="com_prop_apell", type="string", length=100, nullable=false)
     */
    private $comPropApell;

    /**
     * @var string
     *
     * @ORM\Column(name="com_prop_telef_cel", type="string", length=11, nullable=false)
     */
    private $comPropTelefCel;

    /**
     * @var string
     *
     * @ORM\Column(name="com_sada_chk", type="boolean", nullable=false)
     */
    private $comSadaChk;

    /**
     * @var string
     *
     * @ORM\Column(name="com_sada_codi", type="string", length=11, nullable=true)
     */
    private $comSadaCodi;

    /**
     * @var \ComDireccion
     *
     * @ORM\OneToOne(targetEntity="ComDireccion", mappedBy="com", cascade={"persist", "remove"})
     */
    private $direccion;

    /**
     * @var \ComRepres
     *
     * @ORM\OneToMany(targetEntity="ComRepres", mappedBy="com", cascade={"remove"})
     */
    private $repres;

    /**
     * @var \Mcomercio
     *
     * @ORM\OneToMany(targetEntity="Mcomercio", mappedBy="com", cascade={"persist", "remove"})
     */
    private $mcom;

    /**
     * @var \ProdLimite
     *
     * @ORM\OneToMany(targetEntity="ProdLimite", mappedBy="com", cascade={"remove"})
     */
    private $prod;

    /**
     * @var \RegDiario
     *
     * @ORM\OneToMany(targetEntity="RegDiario", mappedBy="com", cascade={"remove"})
     */
    private $reg;

    /**
     * @var string
     *
     * @SerializedName("com_prop")
     * @Type("string")
     * @Accessor(getter="getProp")
     */
    private $prop;

    /**
     * @var string
     *
     * @SerializedName("com_estb_rif")
     * @Type("string")
     * @Accessor(getter="getEstbRif")
     */
    private $estbRif;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->comRif = Utility::upperCase($this->comRif);
        $this->comNombEstb = Utility::upperCase($this->comNombEstb);
        $this->comNumPtte = Utility::upperCase($this->comNumPtte);
        $this->comNumLic = Utility::upperCase($this->comNumLic);
        $this->comTelefFijo = Utility::upperCase($this->comTelefFijo);
        $this->comActEcnma = Utility::upperCase($this->comActEcnma);
        $this->comPropNac = Utility::upperCase($this->comPropNac);
        $this->comPropNomb = Utility::upperCase($this->comPropNomb);
        $this->comPropApell = Utility::upperCase($this->comPropApell);
        $this->comPropTelefCel = Utility::upperCase($this->comPropTelefCel);
        $this->comSadaCodi = Utility::upperCase($this->comSadaCodi);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->comRif = Utility::upperCase($this->comRif);
        $this->comNombEstb = Utility::upperCase($this->comNombEstb);
        $this->comNumPtte = Utility::upperCase($this->comNumPtte);
        $this->comNumLic = Utility::upperCase($this->comNumLic);
        $this->comTelefFijo = Utility::upperCase($this->comTelefFijo);
        $this->comActEcnma = Utility::upperCase($this->comActEcnma);
        $this->comPropNac = Utility::upperCase($this->comPropNac);
        $this->comPropNomb = Utility::upperCase($this->comPropNomb);
        $this->comPropApell = Utility::upperCase($this->comPropApell);
        $this->comPropTelefCel = Utility::upperCase($this->comPropTelefCel);
        $this->comSadaCodi = Utility::upperCase($this->comSadaCodi);
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->repres = new ArrayCollection();
        $this->prod = new ArrayCollection();
        $this->mcom = new ArrayCollection();
        $this->reg = new ArrayCollection();
    }

    /**
     * Get comId.
     *
     * @return int
     */
    public function getComId()
    {
        return $this->comId;
    }

    /**
     * Set comRif.
     *
     * @param string $comRif
     *
     * @return Comercio
     */
    public function setComRif($comRif)
    {
        $this->comRif = $comRif;

        return $this;
    }

    /**
     * Get comRif.
     *
     * @return string
     */
    public function getComRif()
    {
        return $this->comRif;
    }

    /**
     * Set comNombEstb.
     *
     * @param string $comNombEstb
     *
     * @return Comercio
     */
    public function setComNombEstb($comNombEstb)
    {
        $this->comNombEstb = $comNombEstb;

        return $this;
    }

    /**
     * Get comNombEstb.
     *
     * @return string
     */
    public function getComNombEstb()
    {
        return $this->comNombEstb;
    }

    /**
     * Set comNumPtte.
     *
     * @param string $comNumPtte
     *
     * @return Comercio
     */
    public function setComNumPtte($comNumPtte)
    {
        $this->comNumPtte = $comNumPtte;

        return $this;
    }

    /**
     * Get comNumPtte.
     *
     * @return string
     */
    public function getComNumPtte()
    {
        return $this->comNumPtte;
    }

    /**
     * Set comFechptteIni.
     *
     * @param \Date $comFechptteIni
     *
     * @return Comercio
     */
    public function setComFechptteIni(\DateTime $comFechptteIni = null)
    {
        $this->comFechptteIni = $comFechptteIni;

        return $this;
    }

    /**
     * Get comFechptteIni.
     *
     * @return \Date
     */
    public function getComFechptteIni()
    {
        return $this->comFechptteIni;
    }

    /**
     * Set comFechptteFin.
     *
     * @param \Date $comFechptteFin
     *
     * @return Comercio
     */
    public function setComFechptteFin(\DateTime $comFechptteFin = null)
    {
        $this->comFechptteFin = $comFechptteFin;

        return $this;
    }

    /**
     * Get comFechptteFin.
     *
     * @return \Date
     */
    public function getComFechptteFin()
    {
        return $this->comFechptteFin;
    }

    /**
     * Set comCapit.
     *
     * @param float $comCapit
     *
     * @return Comercio
     */
    public function setComCapit($comCapit)
    {
        $this->comCapit = $comCapit;

        return $this;
    }

    /**
     * Get comCapit.
     *
     * @return float
     */
    public function getComCapit()
    {
        return $this->comCapit;
    }

    /**
     * Set comNumLic.
     *
     * @param string $comNumLic
     *
     * @return Comercio
     */
    public function setComNumLic($comNumLic)
    {
        $this->comNumLic = $comNumLic;

        return $this;
    }

    /**
     * Get comNumLic.
     *
     * @return string
     */
    public function getComNumLic()
    {
        return $this->comNumLic;
    }

    /**
     * Set comTelefFijo.
     *
     * @param string $comTelefFijo
     *
     * @return Comercio
     */
    public function setComTelefFijo($comTelefFijo)
    {
        $this->comTelefFijo = $comTelefFijo;

        return $this;
    }

    /**
     * Get comTelefFijo.
     *
     * @return string
     */
    public function getComTelefFijo()
    {
        return $this->comTelefFijo;
    }

    /**
     * Set comActEcnma.
     *
     * @param string $comActEcnma
     *
     * @return Comercio
     */
    public function setComActEcnma($comActEcnma)
    {
        $this->comActEcnma = $comActEcnma;

        return $this;
    }

    /**
     * Get comActEcnma.
     *
     * @return string
     */
    public function getComActEcnma()
    {
        return $this->comActEcnma;
    }

    /**
     * Set comPropNac.
     *
     * @param string $comPropNac
     *
     * @return Comercio
     */
    public function setComPropNac($comPropNac)
    {
        $this->comPropNac = $comPropNac;

        return $this;
    }

    /**
     * Get comPropNac.
     *
     * @return string
     */
    public function getComPropNac()
    {
        return $this->comPropNac;
    }

    /**
     * Set comPropCedu.
     *
     * @param string $comPropCedu
     *
     * @return Comercio
     */
    public function setComPropCedu($comPropCedu)
    {
        $this->comPropCedu = $comPropCedu;

        return $this;
    }

    /**
     * Get comPropCedu.
     *
     * @return string
     */
    public function getComPropCedu()
    {
        return $this->comPropCedu;
    }

    /**
     * Set comPropNomb.
     *
     * @param string $comPropNomb
     *
     * @return Comercio
     */
    public function setComPropNomb($comPropNomb)
    {
        $this->comPropNomb = $comPropNomb;

        return $this;
    }

    /**
     * Get comPropNomb.
     *
     * @return string
     */
    public function getComPropNomb()
    {
        return $this->comPropNomb;
    }

    /**
     * Set comPropApell.
     *
     * @param string $comPropApell
     *
     * @return Comercio
     */
    public function setComPropApell($comPropApell)
    {
        $this->comPropApell = $comPropApell;

        return $this;
    }

    /**
     * Get comPropApell.
     *
     * @return string
     */
    public function getComPropApell()
    {
        return $this->comPropApell;
    }

    /**
     * Set comPropTelefCel.
     *
     * @param string $comPropTelefCel
     *
     * @return Comercio
     */
    public function setComPropTelefCel($comPropTelefCel)
    {
        $this->comPropTelefCel = $comPropTelefCel;

        return $this;
    }

    /**
     * Get comPropTelefCel.
     *
     * @return string
     */
    public function getComPropTelefCel()
    {
        return $this->comPropTelefCel;
    }

    /**
     * Set direccion.
     *
     * @param \AppBundle\Entity\ComDireccion $direccion
     *
     * @return Comercio
     */
    public function setDireccion(\AppBundle\Entity\ComDireccion $direccion = null)
    {
        $this->direccion = $direccion;
        $this->direccion->setCom($this);

        return $this;
    }

    /**
     * Get direccion.
     *
     * @return \AppBundle\Entity\ComDireccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Get comPropNomb comPropApell.
     *
     * @return string
     */
    public function getProp()
    {
        return sprintf('%s %s', $this->comPropNomb, $this->comPropApell);
    }

    /**
     * Get comNombEstb comRif.
     *
     * @return string
     */
    public function getEstbRif()
    {
        return sprintf('%s (%s)', $this->comNombEstb, $this->comRif);
    }

    /**
     * Add repres.
     *
     * @param \AppBundle\Entity\ComRepres $repres
     *
     * @return Comercio
     */
    public function addRepre(\AppBundle\Entity\ComRepres $repres)
    {
        $this->repres[] = $repres;

        return $this;
    }

    /**
     * Remove repres.
     *
     * @param \AppBundle\Entity\ComRepres $repres
     */
    public function removeRepre(\AppBundle\Entity\ComRepres $repres)
    {
        $this->repres->removeElement($repres);
    }

    /**
     * Get repres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRepres()
    {
        return $this->repres;
    }

    /**
     * Add prod.
     *
     * @param \AppBundle\Entity\ProdLimite $prod
     *
     * @return Comercio
     */
    public function addProd(\AppBundle\Entity\ProdLimite $prod)
    {
        $this->prod[] = $prod;

        return $this;
    }

    /**
     * Remove prod.
     *
     * @param \AppBundle\Entity\ProdLimite $prod
     */
    public function removeProd(\AppBundle\Entity\ProdLimite $prod)
    {
        $this->prod->removeElement($prod);
    }

    /**
     * Get prod.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProd()
    {
        return $this->prod;
    }

    /**
     * Add mcom.
     *
     * @param \AppBundle\Entity\Mcomercio $mcom
     *
     * @return Comercio
     */
    public function addMcom(\AppBundle\Entity\Mcomercio $mcom)
    {
        $this->mcom[] = $mcom;
        $mcom->setCom($this);

        return $this;
    }

    /**
     * Remove mcom.
     *
     * @param \AppBundle\Entity\Mcomercio $mcom
     */
    public function removeMcom(\AppBundle\Entity\Mcomercio $mcom)
    {
        $this->mcom->removeElement($mcom);
    }

    /**
     * Get mcom.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMcom()
    {
        return $this->mcom;
    }

    /**
     * Add reg.
     *
     * @param \AppBundle\Entity\RegDiario $reg
     *
     * @return Comercio
     */
    public function addReg(\AppBundle\Entity\RegDiario $reg)
    {
        $this->reg[] = $reg;

        return $this;
    }

    /**
     * Remove reg.
     *
     * @param \AppBundle\Entity\RegDiario $reg
     */
    public function removeReg(\AppBundle\Entity\RegDiario $reg)
    {
        $this->reg->removeElement($reg);
    }

    /**
     * Get reg.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReg()
    {
        return $this->reg;
    }

    /**
     * Set comSadaChk
     *
     * @param  string   $comSadaChk
     * @return Comercio
     */
    public function setComSadaChk($comSadaChk)
    {
        $this->comSadaChk = $comSadaChk;

        return $this;
    }

    /**
     * Get comSadaChk
     *
     * @return string
     */
    public function getComSadaChk()
    {
        return $this->comSadaChk;
    }

    /**
     * Set comSadaCodi
     *
     * @param  string   $comSadaCodi
     * @return Comercio
     */
    public function setComSadaCodi($comSadaCodi)
    {
        $this->comSadaCodi = $comSadaCodi;

        return $this;
    }

    /**
     * Get comSadaCodi
     *
     * @return string
     */
    public function getComSadaCodi()
    {
        return $this->comSadaCodi;
    }
}
