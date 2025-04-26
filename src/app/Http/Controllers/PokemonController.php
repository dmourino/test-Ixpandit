<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    /**
     * @var PokemonService
     */
    protected $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function index(Request $request)
    {
        $search = strtolower(trim($request->query('search', '')));
        $page = max((int)$request->query('page', 1), 1);
        $perPage = 10;

        $allPokemons = $this->pokemonService->getAllPokemons();

        $filtered = $this->pokemonService->filterAndAddImages($allPokemons, $search);

        $paginated = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => url()->current(), 'query' => ['search' => $search]]
        );

        return view('pokemons.index', [
            'pokemons' => $paginated,
            'search' => $search
        ]);
    }
}
