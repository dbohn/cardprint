<?php

namespace App\Cards;

use App\PDFCreator;

class NameCardFormatter implements Formatter
{

    protected $nameFormatter;
    protected $genderFormatter;
    protected $imageFormatter;

    public function __construct($backgroundImage)
    {

        $this->nameFormatter = new TextFormatter();

        $this->genderFormatter = new TextFormatter();

        $this->genderFormatter->setFontSize(20);

        if ($backgroundImage !== null) {
            $this->imageFormatter = new ImageFormatter($backgroundImage);
        }
    }

    public function formatCard(PDFCreator $creator, $card, $xPos, $yPos)
    {
        if ($this->imageFormatter !== null) {
            $this->imageFormatter->formatCard($creator, $card->name, $xPos, $yPos);
        }

        $yOffset = $yPos + $creator->getCardHeight() / 2;
        $textAreaHeight = $creator->getCardHeight() / 2;

        $this->nameFormatter->setYOffset($yOffset);
        $this->nameFormatter->setTextAreaHeight($textAreaHeight);

        $this->nameFormatter->formatCard($creator, $card->getGender() . "\n" . strtoupper($card->name), $xPos, $yPos);
    }
}
