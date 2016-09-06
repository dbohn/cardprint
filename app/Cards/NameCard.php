<?php

namespace App\Cards;

class NameCard implements Card
{

    public $name;

    /**
     * NameCard constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

}
