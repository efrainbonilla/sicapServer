<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;

/**
 * Tcomercio.
 *
 * @ORM\Table(name="tcomercio", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TcomercioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tcomercio
{
    /**
     * @var int
     *
     * @ORM\Column(name="tcom_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tcomId;

    /**
     * @var string
     *
     * @ORM\Column(name="tcom_nomb", type="string", length=100, nullable=false)
     */
    private $tcomNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="tcom_desc", type="text", nullable=false)
     */
    private $tcomDesc;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->tcomNomb = Utility::upperCase($this->tcomNomb);
        $this->tcomDesc = Utility::upperCase($this->tcomDesc);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->tcomNomb = Utility::upperCase($this->tcomNomb);
        $this->tcomDesc = Utility::upperCase($this->tcomDesc);
    }

    /**
     * Get tcomId.
     *
     * @return int
     */
    public function getTcomId()
    {
        return $this->tcomId;
    }

    /**
     * Set tcomNomb.
     *
     * @param string $tcomNomb
     *
     * @return Tcomercio
     */
    public function setTcomNomb($tcomNomb)
    {
        $this->tcomNomb = $tcomNomb;

        return $this;
    }

    /**
     * Get tcomNomb.
     *
     * @return string
     */
    public function getTcomNomb()
    {
        return $this->tcomNomb;
    }

    /**
     * Set tcomDesc.
     *
     * @param string $tcomDesc
     *
     * @return Tcomercio
     */
    public function setTcomDesc($tcomDesc)
    {
        $this->tcomDesc = $tcomDesc;

        return $this;
    }

    /**
     * Get tcomDesc.
     *
     * @return string
     */
    public function getTcomDesc()
    {
        return $this->tcomDesc;
    }
}
