<?php
namespace AppBundle\Controller;

use JasperPHP\JasperPHP;

class JasperPHPCustom extends JasperPHP
{
    public function noscape()
    {
        $this->the_command = str_replace('\\', '', $this->the_command);

        return $this;
    }
}
