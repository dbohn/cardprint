<?php

namespace App\Cards;

use App\PDFCreator;

class ImageFormatter implements Formatter
{

    protected $border = true;

    protected $filename;

    /**
     * ImageFormatter constructor.
     *
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function formatCard(PDFCreator $creator, $name, $xPos, $yPos)
    {
        $creator->pdf->Image(
            $this->filename,
            $xPos,
            $yPos,
            $creator->getCardWidth(),
            $creator->getCardHeight(),
            '', '', '',
            false, 300, '',
            false, false, $this->border
        );
    }
}
