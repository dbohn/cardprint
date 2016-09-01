<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed genus_hybrid
 * @property mixed genus
 * @property mixed species_hybrid
 * @property mixed species
 */
class PlantList extends Model
{
    protected $fillable = [
        'kew_id',
        'major_group',
        'family',
        'genus_hybrid',
        'genus',
        'species_hybrid',
        'species',
        'authorship',
        'taxonomic_state',
        'source',
        'publication',
        'collation',
        'page',
        'date'
    ];

    public function name()
    {
        return collect([$this->genus_hybrid, $this->genus, $this->species_hybrid, $this->species])->reject(function ($el) {
            return empty($el);
        })->implode(" ");
    }
}
