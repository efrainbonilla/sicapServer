<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcomercio.
 *
 * @ORM\Table(name="mcomercio", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="tcom_id", columns={"tcom_id"}), @ORM\Index(name="com_id", columns={"com_id"})})
 * @ORM\Entity
 */
class Mcomercio
{
    /**
     * @var int
     *
     * @ORM\Column(name="mcom_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mcomId;

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
     * @var \Tcomercio
     *
     * @ORM\ManyToOne(targetEntity="Tcomercio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tcom_id", referencedColumnName="tcom_id")
     * })
     */
    private $tcom;

    /**
     * Get mcomId.
     *
     * @return int
     */
    public function getMcomId()
    {
        return $this->mcomId;
    }

    /**
     * Set com.
     *
     * @param \AppBundle\Entity\Comercio $com
     *
     * @return Mcomercio
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
     * Set tcom.
     *
     * @param \AppBundle\Entity\Tcomercio $tcom
     *
     * @return Mcomercio
     */
    public function setTcom(\AppBundle\Entity\Tcomercio $tcom = null)
    {
        $this->tcom = $tcom;

        return $this;
    }

    /**
     * Get tcom.
     *
     * @return \AppBundle\Entity\Tcomercio
     */
    public function getTcom()
    {
        return $this->tcom;
    }
}
