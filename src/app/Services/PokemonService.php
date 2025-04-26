<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PokemonService
{
    const API_URL = 'https://pokeapi.co/api/v2/pokemon?limit=1300';
    public function getAllPokemons()
    {
        $response = Http::get(PokemonService::API_URL);
        return collect($response->json()['results'] ?? []);
    }
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
