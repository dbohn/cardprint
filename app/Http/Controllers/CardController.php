<?php

namespace App\Http\Controllers;

use App\Cards\EmptyCard;
use App\Cards\EmptyCardFormatter;
use App\Cards\ImageFormatter;
use App\Cards\NameCard;
use App\Cards\NameCardFormatter;
use App\Cards\PlantCard;
use App\Cards\PlantCardFormatter;
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
        $cardType = $request->get('card_type', 'name');

        $cards = collect($request->get('cards'))->map(function ($row) use ($cardType) {
            if ($cardType === 'name') {
                return NameCard::fromRequestData($row);
            }

            return PlantCard::fromRequestData($row);
        })->zip(range(0, 9));

        $pdfCreator = new PDFCreator();

        $image = null;

        if ($request->has('withGraphic')) {
            $image = storage_path('app/' . $request->get('backgroundGraphic'));
        }

        $nameCardFormatter = new NameCardFormatter($image);

        $plantCardFormatter = new PlantCardFormatter($image);

        $pdfCreator->addFormatterForCard(NameCard::class,
            $nameCardFormatter);

        $pdfCreator->addFormatterForCard(PlantCard::class, $plantCardFormatter);

        $pdfCreator->addFormatterForCard(EmptyCard::class, new EmptyCardFormatter($image));

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
     * @return \Illuminate\Support\Collection
     */
    protected function findBackgroundImages()
    {
        $files = collect(Storage::files('backgrounds'))->map(function ($file) {
            return ['path' => $file, 'name' => basename($file)];
        })->reject(function ($file) {
            return starts_with($file['name'], '.');
        });

        return $files;
    }
}
