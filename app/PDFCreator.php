<?php

namespace App;

use App\Cards\Formatter;
use Illuminate\Support\Collection;
use TCPDF;

class PDFCreator
{

    /**
     * @var TCPDF
     */
    public $pdf;

    /**
     * Card width in mm
     *
     * @var float
     */
    protected $cardWidth = 90.68;

    /**
     * Card height in mm
     *
     * @var float
     */
    protected $cardHeight = 55.12;

    /**
     * Margin at the left edge of the page
     *
     * @var int
     */
    protected $leftPageMargin = 10;

    /**
     * Margin at the top edge of the page
     *
     * @var int
     */
    protected $topPageMargin = 11;

    /**
     * Margin between the cells in a row
     *
     * @var int
     */
    protected $leftCellMargin = 5;

    /**
     * Margin between the rows of cells
     *
     * @var int
     */
    protected $topCellMargin = 0;

    /**
     * The formatters that are used to fill a card with life
     * @var Collection
     */
    protected $formatters;

    public function __construct()
    {
        $this->formatters = new Collection();
        $this->setupDocument();
    }

    protected function setupDocument()
    {
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document metadata
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('David Bohn');
        $this->pdf->SetTitle('Namensschilder');
        $this->pdf->SetSubject('Namensschilder');

        // Disable header and footer
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        $this->pdf->setFooterMargin(0);

        $this->pdf->SetAutoPageBreak(false);

        $this->pdf->setJPEGQuality(100);

        $this->pdf->AddPage();
    }

    public function addCardAtIndex($name, $index)
    {
        $cardsPerRow = $this->cardsPerRow();
        $row = (int)($index / $cardsPerRow);
        $column = $index % $cardsPerRow;

        $xPos = $this->leftPageMargin + $column * ($this->cardWidth + $this->leftCellMargin);
        $yPos = $this->topPageMargin + $row * ($this->cardHeight + $this->topCellMargin);

        $this->makeCard($name, $xPos, $yPos);
    }

    /**
     * Calculate how many cards there will be per row
     *
     * @return int
     */
    protected function cardsPerRow()
    {
        return intval($this->pdf->getPageWidth() / $this->getCardWidth());
    }

    /**
     * Create a card at the given position for the provided name
     *
     * @param $name
     * @param $xPos
     * @param $yPos
     */
    public function makeCard($name, $xPos, $yPos)
    {
        $creator = $this;

        $this->formatters->each(function (Formatter $formatter) use ($creator, $name, $xPos, $yPos) {
            $formatter->formatCard($creator, $name, $xPos, $yPos);
        });
    }

    public function save($filename, $mode = 'F')
    {
        return $this->pdf->Output($filename, $mode);
    }

    public function addFormatter(Formatter $formatter)
    {
        $this->formatters->push($formatter);

        return $this;
    }

    /**
     * @return float
     */
    public function getCardWidth()
    {
        return $this->cardWidth;
    }

    /**
     * @return float
     */
    public function getCardHeight()
    {
        return $this->cardHeight;
    }
}
