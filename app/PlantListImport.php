<?php

namespace App;

use League\Csv\Reader;

class PlantListImport
{

    protected $csv;

    public function import($path)
    {
        $csv = Reader::createFromPath($path);

        //$header = $csv->fetchOne();
        $csv->setOffset(1);

        $csv->each(function ($row) {
            PlantList::create([
                'kew_id' => $row[0],
                'major_group' => $row[1],
                'family' => $row[2],
                'genus_hybrid' => $row[3],
                'genus' => $row[4],
                'species_hybrid' => $row[5],
                'species' => $row[6],
                'authorship' => $row[9],
                'taxonomic_state' => $row[10],
                'source' => $row[13],
                'publication' => $row[16],
                'collation' => $row[17],
                'page' => $row[18],
                'date' => $row[19],
            ]);

            return true;
        });
    }
}
