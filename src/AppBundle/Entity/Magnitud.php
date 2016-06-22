<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magnitud.
 *
 * @ORM\Table(name="magnitud", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MagnitudRepository")
 */
class Magnitud
{
    /**
     * @var int
     *
     * @ORM\Column(name="mag_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $magId;

    /**
     * @var string
     *
     * @ORM\Column(name="mag_nomb", type="string", length=50, nullable=false)
     */
    private $magNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="mag_simb", type="string", length=10, nullable=false)
     */
    private $magSimb;

    /**
     * Set magId.
     *
     * @param string $magId
     *
     * @return Magnitud
     */
    public function setMagId($magId)
    {
        $this->magId = $magId;

        return $this;
    }

    /**
     * Get magId.
     *
     * @return int
     */
    public function getMagId()
    {
        return $this->magId;
    }

    /**
     * Set magNomb.
     *
     * @param string $magNomb
     *
     * @return Magnitud
     */
    public function setMagNomb($magNomb)
    {
        $this->magNomb = $magNomb;

        return $this;
    }

    /**
     * Get magNomb.
     *
     * @return string
     */
    public function getMagNomb()
    {
        return $this->magNomb;
    }

    /**
     * Set magSimb.
     *
     * @param string $magSimb
     *
     * @return Magnitud
     */
    public function setMagSimb($magSimb)
    {
        $this->magSimb = $magSimb;

        return $this;
    }

    /**
     * Get magSimb.
     *
     * @return string
     */
    public function getMagSimb()
    {
        return $this->magSimb;
    }
}
