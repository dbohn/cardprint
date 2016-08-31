<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('cards/create', function (\Illuminate\Http\Request $request) {

    $cards = collect($request->get('cards'))->zip(range(0,9));

    $pdfCreator = new \App\PDFCreator();

    if ($request->has('withGraphic')) {
        $pdfCreator->addFormatter(new \App\Cards\ImageFormatter(storage_path('namensschild.jpg')));
    }

    $pdfCreator->addFormatter(new \App\Cards\TextFormatter());

    if ($request->has('skipEmpty')) {
        $cards = $cards->reject(function ($row) {
            list($card, $index) = $row;

            return empty($card);
        });
    }

    $cards->map(function ($row) {
        $row[0] = strtoupper($row[0]);
        return $row;
    })->each(function ($row) use ($pdfCreator) {
        list($name, $index) = $row;
        $pdfCreator->addCardAtIndex($name, $index);
    });

    $pdfCreator->save('test.pdf', 'I');
});
