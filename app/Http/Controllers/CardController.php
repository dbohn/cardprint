<?php

namespace App\Http\Controllers;

use App\Cards\EmptyCard;
use App\Cards\EmptyCardFormatter;
use App\Cards\ImageFormatter;
use App\Cards\NameCard;
use App\Cards\NameCardFormatter;
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
        $cards = collect($request->get('cards'))->map(function ($row) {
            return NameCard::fromRequestData($row);
        })->zip(range(0, 9));

        $pdfCreator = new PDFCreator();

        $image = null;

        if ($request->has('withGraphic')) {
            $image = storage_path('app/' . $request->get('backgroundGraphic'));
        }

        $nameCardFormatter = new NameCardFormatter($image);

        $pdfCreator->addFormatterForCard(NameCard::class,
            $nameCardFormatter);

        $pdfCreator->addFormatterForCard(EmptyCard::class, new EmptyCardFormatter());

        if ($request->has('skipEmpty')) {
            $cards = $cards->reject(function ($row) {
                list($card, $index) = $row;

                return $card instanceof EmptyCard;
            });
        }

        $cards->each(function ($row) use ($pdfCreator) {
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
