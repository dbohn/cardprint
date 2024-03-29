<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Search for a person by name
     *
     * @param  Builder $query The query object
     * @param  string  $name  The name searched for
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName(Builder $query, $name)
    {
        return $query->whereRaw('match(genus, species) against (? in boolean mode)', [$name]);
    }
}
