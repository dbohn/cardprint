<?php

namespace App\Cards;

use App\PDFCreator;

class TextFormatter implements Formatter
{

    protected $fontSize = 24;

    protected $fontFamily = 'montserrat';

    /**
     * @var
     */
    private $yOffset;
    /**
     * @var
     */
    private $textAreaHeight;

    public function __construct($yOffset = 0, $textAreaHeight = 0, $fontSize = 24)
    {
        $this->fontSize = $fontSize;

        $this->yOffset = $yOffset;
        $this->textAreaHeight = $textAreaHeight;
    }

    public function setFontSize($size)
    {
        $this->fontSize = $size;
    }

    /**
     * @param mixed $yOffset
     *
     * @return $this
     */
    public function setYOffset($yOffset)
    {
        $this->yOffset = $yOffset;

        return $this;
    }

    /**
     * @param mixed $textAreaHeight
     *
     * @return $this
     */
    public function setTextAreaHeight($textAreaHeight)
    {
        $this->textAreaHeight = $textAreaHeight;

        return $this;
    }

    /**
     * @param string $fontFamily
     */
    public function setFontFamily($fontFamily)
    {
        $this->fontFamily = $fontFamily;
    }

    public function formatCard(PDFCreator $creator, $name, $xPos, $yPos)
    {
        $yOffset = $this->yOffset;
        $textAreaHeight = $this->textAreaHeight;

        $creator->pdf->SetFont($this->fontFamily, '', $this->fontSize, '', false);

        $creator->pdf->MultiCell($creator->getCardWidth(), $textAreaHeight, $name, 0, 'C', false, 1, $xPos, $yOffset,
            true, 0, false, true, $textAreaHeight, 'M', true);
    }
}
