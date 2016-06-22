<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;

/**
 * TranspMarca.
 *
 * @ORM\Table(name="transp_marca", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranspMarcaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TranspMarca
{
    /**
     * @var int
     *
     * @ORM\Column(name="marca_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $marcaId;

    /**
     * @var string
     *
     * @ORM\Column(name="marca_nomb", type="string", length=100, nullable=false)
     */
    private $marcaNomb;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        //$this->marcaNomb = Utility::upperCase($this->marcaNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        //$this->marcaNomb = Utility::upperCase($this->marcaNomb);
    }

    /**
     * Set marcaId.
     *
     * @param string $marcaId
     *
     * @return TranspMarca
     */
    public function setMarcaId($marcaId)
    {
        $this->marcaId = $marcaId;

        return $this;
    }

    /**
     * Get marcaId.
     *
     * @return int
     */
    public function getMarcaId()
    {
        return $this->marcaId;
    }

    /**
     * Set marcaNomb.
     *
     * @param string $marcaNomb
     *
     * @return TranspMarca
     */
    public function setMarcaNomb($marcaNomb)
    {
        $this->marcaNomb = $marcaNomb;

        return $this;
    }

    /**
     * Get marcaNomb.
     *
     * @return string
     */
    public function getMarcaNomb()
    {
        return $this->marcaNomb;
    }
}
