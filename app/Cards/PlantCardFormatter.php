<?php

namespace App\Cards;

use App\PDFCreator;

class PlantCardFormatter implements Formatter
{

    protected $imageFormatter;
    protected $nameFormatter;

    public function __construct($backgroundImage)
    {
        $this->nameFormatter = new TextFormatter();

        $this->nameFormatter->setFontFamily("sourcesanspro");

        if ($backgroundImage !== null) {
            $this->imageFormatter = new ImageFormatter($backgroundImage);
        }
    }

    public function formatCard(PDFCreator $creator, $card, $xPos, $yPos)
    {
        if ($this->imageFormatter !== null) {
            $this->imageFormatter->formatCard($creator, $card->name, $xPos, $yPos);
        }

        $yOffset = $yPos + ($creator->getCardHeight() / 2) - 2;
        $textAreaHeight = $creator->getCardHeight() / 2;

        $this->nameFormatter->setYOffset($yOffset);
        $this->nameFormatter->setTextAreaHeight($textAreaHeight);

        $this->nameFormatter->formatCard($creator, $card->getName(), $xPos, $yPos);
    }
}
