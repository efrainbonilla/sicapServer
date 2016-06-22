<?php

namespace AppBundle\Entity;

use AppBundle\Util\Utility;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria.
 *
 * @ORM\Table(name="categoria", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Categoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $catId;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_nomb", type="string", length=100, nullable=false)
     */
    private $catNomb;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->catNomb = Utility::upperCase($this->catNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->catNomb = Utility::upperCase($this->catNomb);
    }

    /**
     * Set catId.
     *
     * @param string $catId
     *
     * @return Categoria
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;

        return $this;
    }

    /**
     * Get catId.
     *
     * @return int
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * Set catNomb.
     *
     * @param string $catNomb
     *
     * @return Categoria
     */
    public function setCatNomb($catNomb)
    {
        $this->catNomb = $catNomb;

        return $this;
    }

    /**
     * Get catNomb.
     *
     * @return string
     */
    public function getCatNomb()
    {
        return $this->catNomb;
    }
}
