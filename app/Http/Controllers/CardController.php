<?php

namespace App\Http\Controllers;

use App\Cards\ImageFormatter;
use App\Cards\TextFormatter;
use App\PDFCreator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{

    public function index()
    {
        $files = $this->findBackgroundImages();

        return view('welcome', compact('files'));
    }

    public function plants()
    {
        $files = $this->findBackgroundImages();

        return view('plantcard', compact('files'));
    }

    public function createCards(Request $request)
    {
        $cards = collect($request->get('cards'))->zip(range(0, 9));

        $pdfCreator = new PDFCreator();

        if ($request->has('withGraphic')) {
            $pdfCreator->addFormatter(new ImageFormatter(storage_path('app/' . $request->get('backgroundGraphic'))));
        }

        $pdfCreator->addFormatter(new TextFormatter());

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
    }

    /**
     * @return static
     */
    protected function findBackgroundImages()
    {
        $files = collect(Storage::files('backgrounds'))->map(function ($file) {
            return ['path' => $file, 'name' => basename($file)];
        });

        return $files;
    }
}
