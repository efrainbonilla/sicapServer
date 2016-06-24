<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reporte.
 *
 * @ORM\Table(name="reporte", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReporteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Reporte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rpt_module", type="string", length=100, nullable=false)
     */
    private $rptModule;

    /**
     * @var string
     *
     * @ORM\Column(name="rpt_key", type="string", length=100, nullable=false)
     */
    private $rptKey;

    /**
     * @var string
     *
     * @ORM\Column(name="rpt_value", type="string", length=255, nullable=false)
     */
    private $rptValue;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rptModule
     *
     * @param  string  $rptModule
     * @return Reporte
     */
    public function setRptModule($rptModule)
    {
        $this->rptModule = $rptModule;

        return $this;
    }

    /**
     * Get rptModule
     *
     * @return string
     */
    public function getRptModule()
    {
        return $this->rptModule;
    }

    /**
     * Set rptKey
     *
     * @param  string  $rptKey
     * @return Reporte
     */
    public function setRptKey($rptKey)
    {
        $this->rptKey = $rptKey;

        return $this;
    }

    /**
     * Get rptKey
     *
     * @return string
     */
    public function getRptKey()
    {
        return $this->rptKey;
    }

    /**
     * Set rptValue
     *
     * @param  string  $rptValue
     * @return Reporte
     */
    public function setRptValue($rptValue)
    {
        $this->rptValue = $rptValue;

        return $this;
    }

    /**
     * Get rptValue
     *
     * @return string
     */
    public function getRptValue()
    {
        return $this->rptValue;
    }
}
