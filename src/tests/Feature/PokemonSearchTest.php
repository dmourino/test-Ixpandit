<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PokemonSearchTest extends TestCase
{
    public function test_can_search_pokemon(): void
    {
        Cache::flush();

        Http::fake([
            'pokeapi.co/api/v2/pokemon*' => Http::response([
                'results' => [
                    ['name' => 'pikachu', 'url' => 'https://pokeapi.co/api/v2/pokemon/25/'],
                    ['name' => 'pidgey', 'url' => 'https://pokeapi.co/api/v2/pokemon/16/'],
                    ['name' => 'bulbasaur', 'url' => 'https://pokeapi.co/api/v2/pokemon/1/'],
                ]
            ])
        ]);

        $response = $this->get('/?search=pika');

        $response->assertStatus(200);
        $response->assertSee('pikachu');
        $response->assertDontSee('bulbasaur');
    }
}
