<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('pdf', function () {

    $cards = collect([
        'J. Bohn',
        'A. Riechert-Bohn',
        'D. Bohn',
        'A. Werner',
        'K.D. Passlack',
        'D. Bourvieg',
        'K. Naujack',
        'W. Schlie',
        'W. Rudorf',
        'I. Selk'
    ]);

    $pdfCreator = new \App\PDFCreator();

    $pdfCreator->addFormatter(new \App\Cards\ImageFormatter(storage_path('namensschild.jpg')))->addFormatter(new \App\Cards\TextFormatter());

    //$pdfCreator->makeCard("Angela Riechert-Bohn", 0, 0);

    $cards->map(function ($el) {
        return strtoupper($el);
    })->each(function ($name, $index) use ($pdfCreator) {
        $pdfCreator->addCardAtIndex($name, $index);
    });

    $pdfCreator->save(storage_path('test.pdf'));
    //$this->comment('PDF erstellen');

});
