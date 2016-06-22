<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo.
 *
 * @ORM\Table(name="grupo", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="cat_id", columns={"cat_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GrupoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Grupo
{
    /**
     * @var int
     *
     * @ORM\Column(name="grup_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $grupId;

    /**
     * @var string
     *
     * @ORM\Column(name="grup_nomb", type="string", length=100, nullable=false)
     */
    private $grupNomb;

    /**
     * @var string
     *
     * @ORM\Column(name="grup_desc", type="text", nullable=false)
     */
    private $grupDesc;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_id", referencedColumnName="cat_id")
     * })
     */
    private $cat;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->grupNomb = Utility::upperCase($this->grupNomb);
        $this->grupDesc = Utility::upperCase($this->grupDesc);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->grupNomb = Utility::upperCase($this->grupNomb);
        $this->grupDesc = Utility::upperCase($this->grupDesc);
    }

    /**
     * Set grupId.
     *
     * @param string $grupId
     *
     * @return Grupo
     */
    public function setGrupId($grupId)
    {
        $this->grupId = $grupId;

        return $this;
    }

    /**
     * Get grupId.
     *
     * @return int
     */
    public function getGrupId()
    {
        return $this->grupId;
    }

    /**
     * Set grupNomb.
     *
     * @param string $grupNomb
     *
     * @return Grupo
     */
    public function setGrupNomb($grupNomb)
    {
        $this->grupNomb = $grupNomb;

        return $this;
    }

    /**
     * Get grupNomb.
     *
     * @return string
     */
    public function getGrupNomb()
    {
        return $this->grupNomb;
    }

    /**
     * Set grupDesc.
     *
     * @param string $grupDesc
     *
     * @return Grupo
     */
    public function setGrupDesc($grupDesc)
    {
        $this->grupDesc = $grupDesc;

        return $this;
    }

    /**
     * Get grupDesc.
     *
     * @return string
     */
    public function getGrupDesc()
    {
        return $this->grupDesc;
    }

    /**
     * Set cat.
     *
     * @param \AppBundle\Entity\Categoria $cat
     *
     * @return Grupo
     */
    public function setCat(\AppBundle\Entity\Categoria $cat = null)
    {
        $this->cat = $cat;

        return $this;
    }

    /**
     * Get cat.
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCat()
    {
        return $this->cat;
    }
}
