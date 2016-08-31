<?php

namespace App\Cards;

use App\PDFCreator;

interface Formatter
{

    public function formatCard(PDFCreator $creator, $name, $xPos, $yPos);
}
