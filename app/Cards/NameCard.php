<?php

namespace App\Cards;

class NameCard implements Card
{

    public $name;
    /**
     * @var
     */
    public $gender;

    protected $nameFormatter;

    protected $imageFormatter;

    /**
     * NameCard constructor.
     *
     * @param $name
     * @param $gender
     */
    public function __construct($name, $gender)
    {
        $this->name = $name;
        $gender = strtolower($gender);
        if ($gender == 'company') {
            $this->gender = 'company';
        } else {
            $this->gender = (strtolower($gender) == 'female') ? 'female': 'male';
        }
    }

    public static function fromRequestData(array $data)
    {
        if (empty($data['name'])) {
            return new EmptyCard();
        }
        return new static($data['name'], $data['gender']);
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        if ($this->gender == 'company') {
            return 'Firma';
        }

        return ($this->gender == 'female') ? 'Frau' : 'Herr';
    }
}
