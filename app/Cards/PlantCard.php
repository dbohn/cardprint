<?php

namespace App\Cards;

class PlantCard implements Card
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function fromRequestData(array $data)
    {
        if (empty($data['name'])) {
            return new EmptyCard();
        }

        return new static($data['name']);
    }

    public function getName()
    {
        if (str_contains($this->name, ' x ')) {
            return str_replace(' x ', "\n×\n", $this->name);
        }

        return str_replace_first(' ', "\n", $this->name);
    }
}
