<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sgrupo.
 *
 * @ORM\Table(name="sgrupo", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="grup_id", columns={"grup_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SgrupoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Sgrupo
{
    /**
     * @var int
     *
     * @ORM\Column(name="sgrup_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sgrupId;

    /**
     * @var int
     *
     * @ORM\Column(name="sgrup_nomb", type="string", length=100, nullable=false)
     */
    private $sgrupNomb;

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
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->sgrupNomb = Utility::upperCase($this->sgrupNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->sgrupNomb = Utility::upperCase($this->sgrupNomb);
    }

    /**
     * Set sgrupId.
     *
     * @param int $sgrupId
     *
     * @return Sgrupo
     */
    public function setSgrupId($sgrupId)
    {
        $this->sgrupId = $sgrupId;

        return $this;
    }

    /**
     * Get sgrupId.
     *
     * @return int
     */
    public function getSgrupId()
    {
        return $this->sgrupId;
    }

    /**
     * Set sgrupNomb.
     *
     * @param int $sgrupNomb
     *
     * @return Sgrupo
     */
    public function setSgrupNomb($sgrupNomb)
    {
        $this->sgrupNomb = $sgrupNomb;

        return $this;
    }

    /**
     * Get sgrupNomb.
     *
     * @return int
     */
    public function getSgrupNomb()
    {
        return $this->sgrupNomb;
    }

    /**
     * Set grup.
     *
     * @param \AppBundle\Entity\Grupo $grup
     *
     * @return Sgrupo
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
}
