<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use AppBundle\Util\Utility;

/**
 * ComRepres.
 *
 * @ORM\Table(name="com_repres", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="com_id", columns={"com_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComRepresRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ComRepres
{
    /**
     * @var int
     *
     * @ORM\Column(name="repres_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $represId;

    /**
     * @var string
     *
     * @ORM\Column(name="repres_nac", type="string", length=1, nullable=false)
     */
    private $represNac;

    /**
     * @var string
     *
     * @ORM\Column(name="repres_cedu", type="string", length=15, nullable=false)
     */
    private $represCedu;

    /**
     * @var string
     *
     * @ORM\Column(name="repres_nomb", type="string", length=100, nullable=false)
     */
    private $represNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="repres_apell", type="string", length=100, nullable=false)
     */
    private $represApell;

    /**
     * @var string
     *
     * @ORM\Column(name="repres_telef_cel", type="string", length=11, nullable=true)
     */
    private $represTelefCel;

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
     * @var string
     *
     * @SerializedName("repres")
     * @Type("string")
     * @Accessor(getter="getRepres")
     */
    private $repres;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->represNac = Utility::upperCase($this->represNac);
        $this->represCedu = Utility::upperCase($this->represCedu);
        $this->represNomb = Utility::upperCase($this->represNomb);
        $this->represApell = Utility::upperCase($this->represApell);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->represNac = Utility::upperCase($this->represNac);
        $this->represCedu = Utility::upperCase($this->represCedu);
        $this->represNomb = Utility::upperCase($this->represNomb);
        $this->represApell = Utility::upperCase($this->represApell);
    }

    /**
     * Get represId.
     *
     * @return int
     */
    public function getRepresId()
    {
        return $this->represId;
    }

    /**
     * Set represNac.
     *
     * @param string $represNac
     *
     * @return ComRepres
     */
    public function setRepresNac($represNac)
    {
        $this->represNac = $represNac;

        return $this;
    }

    /**
     * Get represNac.
     *
     * @return string
     */
    public function getRepresNac()
    {
        return $this->represNac;
    }

    /**
     * Set represCedu.
     *
     * @param string $represCedu
     *
     * @return ComRepres
     */
    public function setRepresCedu($represCedu)
    {
        $this->represCedu = $represCedu;

        return $this;
    }

    /**
     * Get represCedu.
     *
     * @return string
     */
    public function getRepresCedu()
    {
        return $this->represCedu;
    }

    /**
     * Set represNomb.
     *
     * @param string $represNomb
     *
     * @return ComRepres
     */
    public function setRepresNomb($represNomb)
    {
        $this->represNomb = $represNomb;

        return $this;
    }

    /**
     * Get represNomb.
     *
     * @return string
     */
    public function getRepresNomb()
    {
        return $this->represNomb;
    }

    /**
     * Set represApell.
     *
     * @param string $represApell
     *
     * @return ComRepres
     */
    public function setRepresApell($represApell)
    {
        $this->represApell = $represApell;

        return $this;
    }

    /**
     * Get represApell.
     *
     * @return string
     */
    public function getRepresApell()
    {
        return $this->represApell;
    }

    /**
     * Set represTelefCel.
     *
     * @param string $represTelefCel
     *
     * @return ComRepres
     */
    public function setRepresTelefCel($represTelefCel)
    {
        $this->represTelefCel = $represTelefCel;

        return $this;
    }

    /**
     * Get represTelefCel.
     *
     * @return string
     */
    public function getRepresTelefCel()
    {
        return $this->represTelefCel;
    }

    /**
     * Set com.
     *
     * @param \AppBundle\Entity\Comercio $com
     *
     * @return ComRepres
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
     * Get represNomb represApell.
     *
     * @return string
     */
    public function getRepres()
    {
        return sprintf('%s %s', $this->represNomb, $this->represApell);
    }
}
