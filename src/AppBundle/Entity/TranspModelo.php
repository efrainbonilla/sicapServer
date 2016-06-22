<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Utility;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

/**
 * TranspModelo.
 *
 * @ORM\Table(name="transp_modelo", options={"collate"="utf8_general_ci", "charset"="utf8"}, indexes={@ORM\Index(name="marca_id", columns={"marca_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranspModeloRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TranspModelo
{
    /**
     * @var int
     *
     * @ORM\Column(name="modelo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $modeloId;

    /**
     * @var int
     *
     * @ORM\Column(name="modelo_anio", type="integer", length=11, nullable=false)
     */
    private $modeloAnio;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo_nomb", type="string", length=100, nullable=false)
     */
    private $modeloNomb;

    /**
     * @var \TranspMarca
     *
     * @ORM\ManyToOne(targetEntity="TranspMarca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marca_id", referencedColumnName="marca_id")
     * })
     */
    private $marca;


    /**
     * @var string
     *
     * @SerializedName("model_anio")
     * @Type("string")
     * @Accessor(getter="getModelAnio")
     */
    private $modelAnio;

    /**
     * Hook on pre-persist operations.
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->modeloNomb = Utility::upperCase($this->modeloNomb);
    }

    /**
     * Hook on pre-update operations.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->modeloNomb = Utility::upperCase($this->modeloNomb);
    }

    /**
     * Get modeloId.
     *
     * @return int
     */
    public function getModeloId()
    {
        return $this->modeloId;
    }

    /**
     * Set modeloId.
     *
     * @param string $modeloId
     *
     * @return TranspModelo
     */
    public function setModeloId($modeloId)
    {
        $this->modeloId = $modeloId;

        return $this;
    }
    /**
     * Set modeloNomb.
     *
     * @param string $modeloNomb
     *
     * @return TranspModelo
     */
    public function setModeloNomb($modeloNomb)
    {
        $this->modeloNomb = $modeloNomb;

        return $this;
    }

    /**
     * Get modeloNomb.
     *
     * @return string
     */
    public function getModeloNomb()
    {
        return $this->modeloNomb;
    }

    /**
     * Set marca.
     *
     * @param \AppBundle\Entity\TranspMarca $marca
     *
     * @return TranspModelo
     */
    public function setMarca(\AppBundle\Entity\TranspMarca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca.
     *
     * @return \AppBundle\Entity\TranspMarca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modeloAnio
     *
     * @param integer $modeloAnio
     * @return TranspModelo
     */
    public function setModeloAnio($modeloAnio)
    {
        $this->modeloAnio = $modeloAnio;

        return $this;
    }

    /**
     * Get modeloAnio
     *
     * @return integer 
     */
    public function getModeloAnio()
    {
        return $this->modeloAnio;
    }

    /**
     * Get modeloNomb modeloAnio.
     *
     * @return string
     */
    public function getModelAnio()
    {
        return sprintf('%s (%d)', $this->modeloNomb, $this->modeloAnio);
    }
}
