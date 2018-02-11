<?php

namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends \Twig_Extension
{
    private $cssArray = [];
    public function getFilters(){

        return array(
            new \Twig_SimpleFilter('cssloader',array($this,'cssloader')),
        );
    }

    public function cssloader($cssname){
        $this->cssArray[] = $cssname;
    }
}