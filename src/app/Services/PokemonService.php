<?php

namespace App\Services;

use Illuminate\Support\Str;

class PokemonService
{
    public function filterAndAddImages($allPokemons, $search)
    {
        return $allPokemons->filter(function ($pokemon) use ($search) {
            return !$search || Str::contains(Str::lower($pokemon['name']), $search);
        })->map(function ($pokemon) {
            preg_match('/\/pokemon\/(\d+)\//', $pokemon['url'], $matches);
            $id = $matches[1] ?? null;

            if ($id) {
                $pokemon['image'] = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$id}.png";
            } else {
                $pokemon['image'] = null;
            }

            return $pokemon;
        })->values();
    }
}
