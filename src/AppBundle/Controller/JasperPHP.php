<?php
namespace AppBundle\Controller;

use JasperPHP\JasperPHP as OriginalJasperPHP;

class JasperPHP extends OriginalJasperPHP
{
    public function noscape()
    {
        $this->the_command = str_replace('\\', '', $this->the_command);

        return $this;
    }
}
