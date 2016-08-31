<?php

namespace App\Cards;

use App\PDFCreator;

class TextFormatter implements Formatter
{

    public function formatCard(PDFCreator $creator, $name, $xPos, $yPos)
    {
        $yOffset = $yPos + $creator->getCardHeight() / 2;
        $textAreaHeight = $creator->getCardHeight() / 2;

        $creator->pdf->SetFont('montserrat', '', 24, '', false);

        $creator->pdf->MultiCell($creator->getCardWidth(), $textAreaHeight, $name, 0, 'C', false, 1, $xPos, $yOffset, true, 0,
            false, true, $textAreaHeight, 'M', true);
    }
}
