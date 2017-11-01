<?php

namespace AppBundle\Twig;

use Twig_SimpleFilter;

class InArrayExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [new Twig_SimpleFilter('inArray', [$this, 'inArray'])];
    }

    public function inArray($array, $method, $filter)
    {
        $filterArray = $array->filter(function ($entry) use($method, $filter) {
           return in_array($entry->$method(), [$filter]);
        });

        return $filterArray;
    }

    public function getName()
    {
        return 'inArray_extension';
    }
}