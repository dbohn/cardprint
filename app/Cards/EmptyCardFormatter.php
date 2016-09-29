<?php

namespace App\Cards;

use App\PDFCreator;

class EmptyCardFormatter implements Formatter
{

    protected $imageFormatter;

    public function __construct($backgroundImage)
    {
        if ($backgroundImage !== null) {
            $this->imageFormatter = new ImageFormatter($backgroundImage);
        }
    }

    public function formatCard(PDFCreator $creator, $card, $xPos, $yPos)
    {
        if ($this->imageFormatter !== null) {
            $this->imageFormatter->formatCard($creator, null, $xPos, $yPos);
        }
    }
}
