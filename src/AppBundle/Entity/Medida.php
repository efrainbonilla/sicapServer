<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;

/**
 * Medida.
 *
 * @ORM\Table(name="medida", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="mag_id", columns={"mag_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedidaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Medida
{
    /**
     * @var int
     *
     * @ORM\Column(name="med_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $medId;

    /**
     * @var string
     *
     * @ORM\Column(name="med_nomb", type="string", length=50, nullable=false, unique=true)
     */
    private $medNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="med_simb", type="string", length=10, nullable=false)
     */
    private $medSimb;

    /**
     * @var \Magnitud
     *
     * @ORM\ManyToOne(targetEntity="Magnitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mag_id", referencedColumnName="mag_id")
     * })
     */
    private $mag;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->medNomb = Utility::upperCase($this->medNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->medNomb = Utility::upperCase($this->medNomb);
    }

    /**
     * Set medId.
     *
     * @param string $medId
     *
     * @return Medida
     */
    public function setMedId($medId)
    {
        $this->medId = $medId;

        return $this;
    }

    /**
     * Get medId.
     *
     * @return int
     */
    public function getMedId()
    {
        return $this->medId;
    }

    /**
     * Set medNomb.
     *
     * @param string $medNomb
     *
     * @return Medida
     */
    public function setMedNomb($medNomb)
    {
        $this->medNomb = $medNomb;

        return $this;
    }

    /**
     * Get medNomb.
     *
     * @return string
     */
    public function getMedNomb()
    {
        return $this->medNomb;
    }

    /**
     * Set medSimb.
     *
     * @param string $medSimb
     *
     * @return Medida
     */
    public function setMedSimb($medSimb)
    {
        $this->medSimb = $medSimb;

        return $this;
    }

    /**
     * Get medSimb.
     *
     * @return string
     */
    public function getMedSimb()
    {
        return $this->medSimb;
    }

    /**
     * Set mag.
     *
     * @param \AppBundle\Entity\Magnitud $mag
     *
     * @return Medida
     */
    public function setMag(\AppBundle\Entity\Magnitud $mag = null)
    {
        $this->mag = $mag;

        return $this;
    }

    /**
     * Get mag.
     *
     * @return \AppBundle\Entity\Magnitud
     */
    public function getMag()
    {
        return $this->mag;
    }
}
